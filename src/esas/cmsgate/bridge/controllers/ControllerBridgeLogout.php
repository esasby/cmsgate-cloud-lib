<?php


namespace esas\cmsgate\bridge\controllers;


use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\bridge\view\admin\CookieBridge;
use esas\cmsgate\controllers\Controller;

class ControllerBridgeLogout extends Controller
{
    public function process() {
        setcookie(CookieBridge::ID, "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie(CookieBridge::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
        BridgeConnector::fromRegistry()->getMerchantService()->getRedirectService()->loginPage(true);
    }
}