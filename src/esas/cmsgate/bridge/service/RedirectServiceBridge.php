<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\Registry;
use esas\cmsgate\service\RedirectService;

class RedirectServiceBridge extends RedirectService implements RedirectServiceMerchant
{
    const PATH_CONFIG = '/config';
    const PATH_CONFIG_SECRET_NEW = '/config/secret/new';
    const PATH_CONFIG_LOGIN = '/config/login';
    const PATH_CONFIG_LOGOUT = '/config/logout';

    /**
     * @return $this
     * @throws \esas\cmsgate\utils\CMSGateException
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(RedirectService::class, new RedirectServiceBridge());
    }

    public function loginPage($sendHeader = false) {
        return self::returnAbsolutePathOrRedirect(self::PATH_CONFIG_LOGIN, $sendHeader);
    }

    public function logoutPage($sendHeader = false) {
        return self::returnAbsolutePathOrRedirect(self::PATH_CONFIG_LOGOUT, $sendHeader);
    }

    public function mainPage($sendHeader = false) {
        return self::returnAbsolutePathOrRedirect(self::PATH_CONFIG, $sendHeader);
    }

    public function secretGenerate() {
        return self::returnAbsolutePathOrRedirect(self::PATH_CONFIG_SECRET_NEW, false);
    }

    public function shopConfig($sendHeader = false) {
        return self::returnAbsolutePathOrRedirect(self::PATH_CONFIG, $sendHeader);
    }
}