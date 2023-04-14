<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\controllers\Controller;
use esas\cmsgate\controllers\ControllerBridgeLogin;
use esas\cmsgate\controllers\ControllerBridgeLogout;
use esas\cmsgate\utils\StringUtils;
use esas\cmsgate\view\admin\AdminBuyNowExceptionPage;
use esas\cmsgate\view\RedirectServiceBridge;
use esas\cmsgate\view\RedirectServiceBuyNow;
use Exception;
use Throwable;

class ControllerBridge extends Controller
{

    public function process() {
        try {
            $request = $_SERVER['REDIRECT_URL'];
            $controller = null;
            if (StringUtils::endsWith($request, RedirectServiceBridge::PATH_CONFIG_LOGIN)) {
                $controller = new ControllerBridgeLogin();
            } elseif (StringUtils::endsWith($request, RedirectServiceBridge::PATH_CONFIG_LOGOUT)) {
                $controller = new ControllerBridgeLogout();
            } elseif (StringUtils::contains($request, RedirectServiceBridge::PATH_CONFIG)) {
                $controller = new ControllerBridgeConfig();
            } elseif (StringUtils::contains($request, RedirectServiceBridge::PATH_CONFIG_SECRET_NEW)) {
                $controller = new ControllerBridgeSecretGenerate();
            } else {
                http_response_code(404);
            }
            $controller->process();
        } catch (Throwable $e) {
            AdminBuyNowExceptionPage::builder()->buildAndDisplay();
        } catch (Exception $e) {
            AdminBuyNowExceptionPage::builder()->buildAndDisplay();
        }
    }
}