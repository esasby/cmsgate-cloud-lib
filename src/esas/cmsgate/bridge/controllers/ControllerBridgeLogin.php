<?php


namespace esas\cmsgate\bridge\controllers;

use esas\cmsgate\bridge\service\MerchantService;
use esas\cmsgate\bridge\service\RedirectServiceBridge;
use esas\cmsgate\bridge\view\client\RequestParamsBridge;
use esas\cmsgate\controllers\Controller;
use esas\cmsgate\hro\pages\AdminLoginPageHROFactory;
use Exception;
use Throwable;

class ControllerBridgeLogin extends Controller
{
    public function process()
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    AdminLoginPageHROFactory::findBuilder()->render();
                    break;
                case 'POST':
                    $login = $_POST[RequestParamsBridge::LOGIN_FORM_LOGIN];
                    $password = $_POST[RequestParamsBridge::LOGIN_FORM_PASSWORD];
                    MerchantService::fromRegistry()->doLogin($login, $password);
                    RedirectServiceBridge::fromRegistry()->mainPage(true);
                    break;
            }
        } catch (Throwable $e) {
            AdminLoginPageHROFactory::findBuilder()->render();
        } catch (Exception $e) { // для совместимости с php 5
            AdminLoginPageHROFactory::findBuilder()->render();
        }
    }
}