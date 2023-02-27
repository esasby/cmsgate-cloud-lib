<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\view\admin\CookieBridge;

class ControllerBridgeLogout extends Controller
{
    public function process() {
        setcookie(CookieBridge::ID, "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie(CookieBridge::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
        BridgeConnector::fromRegistry()->getMerchantService()->getRedirectService()->loginPage(true);
    }
}