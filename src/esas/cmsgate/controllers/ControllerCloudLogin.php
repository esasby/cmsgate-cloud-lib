<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\security\CryptService;
use esas\cmsgate\utils\RedirectUtilsCloud;
use esas\cmsgate\view\admin\CookieCloud;
use esas\cmsgate\view\client\RequestParamsCloud;
use Exception;
use Throwable;

class ControllerCloudLogin extends Controller
{
    public function process()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    CloudRegistry::getRegistry()->getAdminLoginPage()->render();
                    break;
                case 'POST':
                    $this->doLogin();
                    RedirectUtilsCloud::configPage(true);
                    break;
            }
        } catch (Throwable $e) {
            CloudRegistry::getRegistry()->getAdminLoginPage()->render();
        } catch (Exception $e) { // для совместимости с php 5
            CloudRegistry::getRegistry()->getAdminLoginPage()->render();
        }

    }

    private function doLogin() {
        $login = $_POST[RequestParamsCloud::LOGIN_FORM_LOGIN];
        $password = $_POST[RequestParamsCloud::LOGIN_FORM_PASSWORD];
        $loggerMainString = "Login[" . $login . "]: ";
        $this->logger->info($loggerMainString . "Controller started");
        try {
            Registry::getRegistry()->getPaysystemConnector()->checkAuth($login, $password, CloudRegistry::getRegistry()->isSandbox());
            $hash = md5(CryptService::generateCode(10));
            $authId = CloudRegistry::getRegistry()->getConfigCacheRepository()->addOrUpdateAuth($login, $password, $hash);
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
        setcookie(CookieCloud::ID, $authId, time() + 60 * 15, "/");
        setcookie(CookieCloud::HASH, $hash, time() + 60 * 15, "/", null, null, true); // httponly !!!
    }
}