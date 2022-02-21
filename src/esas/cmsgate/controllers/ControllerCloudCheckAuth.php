<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\view\admin\CookieCloud;

class ControllerCloudCheckAuth extends Controller
{
    public function process()
    {
        if (!isset($_COOKIE[CookieCloud::ID]) || !isset($_COOKIE[CookieCloud::HASH]))
            throw new CMSGateException('Cookies are not set', 'Access denied. Please log in');
        $authHash = CloudRegistry::getRegistry()->getConfigCacheRepository()->getAuthHashById($_COOKIE[CookieCloud::ID]);
        if (($authHash !== $_COOKIE[CookieCloud::HASH])) {
            setcookie(CookieCloud::ID, "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie(CookieCloud::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
            throw new CMSGateException('Cookies hash is incorrect', 'Access denied. Please log in');
        }
    }
}