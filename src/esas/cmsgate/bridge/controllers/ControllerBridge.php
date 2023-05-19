<?php
namespace esas\cmsgate\bridge\controllers;

use esas\cmsgate\bridge\service\RedirectServiceBridge;
use esas\cmsgate\controllers\Controller;
use esas\cmsgate\utils\StringUtils;
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
            //todo
        } catch (Exception $e) {
            //todo
        }
    }
}