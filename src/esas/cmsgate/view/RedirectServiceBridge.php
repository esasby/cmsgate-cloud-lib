<?php


namespace esas\cmsgate\view;



class RedirectServiceBridge extends RedirectService
{
    const PATH_CONFIG = '/config';
    const PATH_ORDERS = '/orders';
    const PATH_CONFIG_SECRET_NEW = '/config/secret/new';
    const PATH_CONFIG_LOGIN = '/config/login';
    const PATH_CONFIG_LOGOUT = '/config/logout';

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
        return self::returnAbsolutePathOrRedirect(self::PATH_CONFIG_SECRET_NEW, fa);
    }

    public function shopConfig($sendHeader = false) {
        return self::returnAbsolutePathOrRedirect(self::PATH_CONFIG, $sendHeader);
    }
}