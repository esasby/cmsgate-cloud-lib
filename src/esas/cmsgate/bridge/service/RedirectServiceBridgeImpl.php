<?php
namespace esas\cmsgate\bridge\service;

class RedirectServiceBridgeImpl extends RedirectServiceBridge
{
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