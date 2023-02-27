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
                    BridgeConnector::fromRegistry()->getMerchantService()->getAdminLoginPage()->render();
                    break;
                case 'POST':
                    $login = $_POST[RequestParamsBridge::LOGIN_FORM_LOGIN];
                    $password = $_POST[RequestParamsBridge::LOGIN_FORM_PASSWORD];
                    BridgeConnector::fromRegistry()->getMerchantService()->doLogin($login, $password);
                    BridgeConnector::fromRegistry()->getMerchantService()->getRedirectService()->mainPage(true);
                    break;
            }
        } catch (Throwable $e) {
            BridgeConnector::fromRegistry()->getMerchantService()->getAdminLoginPage()->render();
        } catch (Exception $e) { // для совместимости с php 5
            BridgeConnector::fromRegistry()->getMerchantService()->getAdminLoginPage()->render();
        }
    }
}