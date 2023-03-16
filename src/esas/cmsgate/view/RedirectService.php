<?php
namespace esas\cmsgate\view;

use esas\cmsgate\utils\URLUtils;

abstract class RedirectService
{
    public static function redirect($location) {
        header('Location: '. $location);
        die();
    }

    public static function returnAbsolutePathOrRedirect($relativePath, $sendHeader = false) {
        $location = URLUtils::getCurrentURLMainPart() . $relativePath;
        if ($sendHeader)
            self::redirect($location);
        return $location;
    }

    public abstract function loginPage($sendHeader = false);

    public abstract function logoutPage($sendHeader = false);

    public abstract function mainPage($sendHeader = false);
}