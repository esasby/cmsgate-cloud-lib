<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\bridge\dao\Merchant;
use esas\cmsgate\bridge\security\CryptService;
use esas\cmsgate\bridge\view\admin\CookieBridge;
use esas\cmsgate\Registry;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CMSGateException;
use Exception;
use Throwable;

abstract class MerchantService extends Service
{
    public function doLogin($login, $password) {
        $loggerMainString = "Login[" . $login . "]: ";
        $this->logger->info($loggerMainString . " service started");
        try {
            Registry::getRegistry()->getPaysystemConnector()->checkAuth($login, $password, BridgeConnector::fromRegistry()->isSandbox());
            $hash = md5(CryptService::generateCode(10));
            $authId = $this->addOrUpdateAuth($login, $password, $hash);
            self::setOrUpdateCookie($authId, $hash);
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Service exception! ", $e);
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
            throw $e;
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error($loggerMainString . "Service exception! ", $e);
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
            throw $e;
        }
    }

    public function checkAuth($redirectToLogin = false) {
        try {
            if (!isset($_COOKIE[CookieBridge::ID]) || !isset($_COOKIE[CookieBridge::HASH]))
                throw new CMSGateException('Cookies are not set', 'Access denied. Please log in');
            $authHash = $this->getAuthHashById($_COOKIE[CookieBridge::ID]);
            if (($authHash !== $_COOKIE[CookieBridge::HASH])) {
                setcookie(CookieBridge::ID, "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie(CookieBridge::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
                throw new CMSGateException('Cookies hash is incorrect', 'Access denied. Please log in');
            }
            self::setOrUpdateCookie($_COOKIE[CookieBridge::ID], $_COOKIE[CookieBridge::HASH]);
            SessionServiceBridge::fromRegistry()::setMerchantUUID($_COOKIE[CookieBridge::ID]);
            if ($this->isSingleShopConfigMode())
                SessionServiceBridge::fromRegistry()::setShopConfigUUID($_COOKIE[CookieBridge::ID]);
        } catch (CMSGateException $e) {
            if ($redirectToLogin) {
                $this->logger->error("Controller exception! ", $e);
                Registry::getRegistry()->getMessenger()->addErrorMessage($e->getClientMsg());
                $this->getRedirectService()->loginPage(true);
            }
            throw $e;
        }
    }

    public static function setOrUpdateCookie($authId, $hash) {
        setcookie(CookieBridge::ID, $authId, time() + 60 * 15, "/");
        setcookie(CookieBridge::HASH, $hash, time() + 60 * 15, "/", null, null, true); // httponly !!!
    }

    /**
     * @return Merchant
     * @throws CMSGateException
     */
    public function getMerchantObj() {
        $merchant = SessionServiceBridge::fromRegistry()::getMerchantObj();
        if ($merchant != null)
            return $merchant;
        $shopConfig = SessionServiceBridge::fromRegistry()::getShopConfigObj();
        if ($shopConfig == null)
            return null;
        $merchant = BridgeConnector::fromRegistry()->getMerchantRepository()->getById($shopConfig->getMerchantId());
        SessionServiceBridge::fromRegistry()::setMerchantObj($merchant);
        return $merchant;
    }

    /**
     * Признак того, что для одного мерчантам может быть только одна конфигурация мазазина. В этом режиме фактическе merchant_id = shop_config_id
     * @return bool
     */
    public function isSingleShopConfigMode() {
        return true;
    }

    public abstract function addOrUpdateAuth($login, $password, $hash);

    public abstract function getAuthHashById($id);

    /**
     * @var RedirectServiceBridge
     */
    protected $redirectService;

    /**
     * @return RedirectServiceBridge
     */
    public function getRedirectService() {
        if ($this->redirectService != null)
            return $this->redirectService;
        else
            $this->redirectService = $this->createRedirectService();
        return $this->redirectService;
    }

    public function createRedirectService() {
        return new RedirectServiceBridgeImpl();
    }
}