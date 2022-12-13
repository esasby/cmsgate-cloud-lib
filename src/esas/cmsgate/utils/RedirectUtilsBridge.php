<?php


namespace esas\cmsgate\utils;


class RedirectUtilsBridge
{
    public static function redirect($location) {
        header('Location: '. $location);
        die();
    }

    public static function loginPage($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . PATH_CONFIG_LOGIN;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public static function logout($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . PATH_CONFIG_LOGOUT;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public static function configPage($sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . PATH_CONFIG;
        return $sendHeader ? self::redirect($location) : $location;
    }

    public static function secretGenerate() {
        return URLUtils::getCurrentURLMainPart() . PATH_CONFIG_SECRET_NEW;
    }
}