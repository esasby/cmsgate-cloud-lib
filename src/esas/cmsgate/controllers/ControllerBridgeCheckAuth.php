<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\SessionUtilsBridge;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\RedirectUtilsBridge;
use esas\cmsgate\view\admin\CookieBridge;

class ControllerBridgeCheckAuth extends Controller
{
    public function process($redirectToLogin = false)
    {
        try {
            if (!isset($_COOKIE[CookieBridge::ID]) || !isset($_COOKIE[CookieBridge::HASH]))
                throw new CMSGateException('Cookies are not set', 'Access denied. Please log in');
            $authHash = BridgeConnector::fromRegistry()->getShopConfigRepository()->getAuthHashById($_COOKIE[CookieBridge::ID]);
            if (($authHash !== $_COOKIE[CookieBridge::HASH])) {
                setcookie(CookieBridge::ID, "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie(CookieBridge::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
                throw new CMSGateException('Cookies hash is incorrect', 'Access denied. Please log in');
            }
            ControllerBridgeLogin::setOrUpdateCookie($_COOKIE[CookieBridge::ID], $_COOKIE[CookieBridge::HASH]);
            SessionUtilsBridge::setConfigCacheUUID($_COOKIE[CookieBridge::ID]);
        } catch (CMSGateException $e) {
            if ($redirectToLogin) {
                $this->logger->error( "Controller exception! ", $e);
                Registry::getRegistry()->getMessenger()->addErrorMessage($e->getClientMsg());
                RedirectUtilsBridge::loginPage(true);
            }
            throw $e;
        }
    }
}