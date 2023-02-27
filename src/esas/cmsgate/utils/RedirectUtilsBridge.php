<?php


namespace esas\cmsgate\utils;


class RedirectUtilsBridge
{
    const PATH_CONFIG = '/config';
    const PATH_CONFIG_SECRET_NEW = '/config/secret/new';
    const PATH_CONFIG_LOGIN = '/config/login';
    const PATH_CONFIG_LOGOUT = '/config/logout';

    public static function redirect($location) {
        header('Location: '. $location);
        die();
    }

    public static function loginPage($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG_LOGIN;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public static function logout($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG_LOGOUT;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public static function configPage($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public static function secretGenerate() {
        return URLUtils::getCurrentURLMainPart() . self::PATH_CONFIG_SECRET_NEW;
    }
}