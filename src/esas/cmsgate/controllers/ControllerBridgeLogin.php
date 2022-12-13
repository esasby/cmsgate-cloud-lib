<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\security\CryptService;
use esas\cmsgate\utils\RedirectUtilsBridge;
use esas\cmsgate\view\admin\CookieBridge;
use esas\cmsgate\view\client\RequestParamsBridge;
use Exception;
use Throwable;

class ControllerBridgeLogin extends Controller
{
    public function process()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    BridgeConnector::fromRegistry()->getAdminLoginPage()->render();
                    break;
                case 'POST':
                    $this->doLogin();
                    RedirectUtilsBridge::configPage(true);
                    break;
            }
        } catch (Throwable $e) {
            BridgeConnector::fromRegistry()->getAdminLoginPage()->render();
        } catch (Exception $e) { // для совместимости с php 5
            BridgeConnector::fromRegistry()->getAdminLoginPage()->render();
        }

    }

    private function doLogin() {
        $login = $_POST[RequestParamsBridge::LOGIN_FORM_LOGIN];
        $password = $_POST[RequestParamsBridge::LOGIN_FORM_PASSWORD];
        $loggerMainString = "Login[" . $login . "]: ";
        $this->logger->info($loggerMainString . "Controller started");
        try {
            Registry::getRegistry()->getPaysystemConnector()->checkAuth($login, $password, BridgeConnector::fromRegistry()->isSandbox());
            $hash = md5(CryptService::generateCode(10));
            $authId = BridgeConnector::fromRegistry()->getShopConfigRepository()->addOrUpdateAuth($login, $password, $hash);
            self::setOrUpdateCookie($authId, $hash);
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
            throw $e;
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
            throw $e;
        }
    }

    public static function setOrUpdateCookie($authId, $hash) {
        setcookie(CookieBridge::ID, $authId, time() + 60 * 15, "/");
        setcookie(CookieBridge::HASH, $hash, time() + 60 * 15, "/", null, null, true); // httponly !!!
    }
}