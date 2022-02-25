<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CloudSessionUtils;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\RedirectUtilsCloud;
use esas\cmsgate\view\admin\CookieCloud;

class ControllerCloudCheckAuth extends Controller
{
    public function process($redirectToLogin = false)
    {
        try {
            if (!isset($_COOKIE[CookieCloud::ID]) || !isset($_COOKIE[CookieCloud::HASH]))
                throw new CMSGateException('Cookies are not set', 'Access denied. Please log in');
            $authHash = CloudRegistry::getRegistry()->getConfigCacheRepository()->getAuthHashById($_COOKIE[CookieCloud::ID]);
            if (($authHash !== $_COOKIE[CookieCloud::HASH])) {
                setcookie(CookieCloud::ID, "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie(CookieCloud::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
                throw new CMSGateException('Cookies hash is incorrect', 'Access denied. Please log in');
            }
            ControllerCloudLogin::setOrUpdateCookie($_COOKIE[CookieCloud::ID], $_COOKIE[CookieCloud::HASH]);
            CloudSessionUtils::setConfigCacheUUID($_COOKIE[CookieCloud::ID]);
        } catch (CMSGateException $e) {
            if ($redirectToLogin) {
                $this->logger->error( "Controller exception! ", $e);
                Registry::getRegistry()->getMessenger()->addErrorMessage($e->getClientMsg());
                RedirectUtilsCloud::loginPage(true);
            }
            throw $e;
        }
    }
}