<?php


namespace esas\cmsgate\view;


use esas\cmsgate\utils\URLUtils;

class RedirectServiceBridge extends RedirectService
{
    const PATH_CONFIG = '/config';
    const PATH_CONFIG_SECRET_NEW = '/config/secret/new';
    const PATH_CONFIG_LOGIN = '/config/login';
    const PATH_CONFIG_LOGOUT = '/config/logout';

    public function loginPage($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG_LOGIN;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public function logoutPage($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG_LOGOUT;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public function mainPage($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public function secretGenerate() {
        return URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG_SECRET_NEW;
    }
}