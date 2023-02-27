<?php
namespace esas\cmsgate\view;

abstract class RedirectService
{
    public static function redirect($location) {
        header('Location: '. $location);
        die();
    }

    public abstract function loginPage($sendHeader = false);

    public abstract function logoutPage($sendHeader = false);

    public abstract function mainPage($sendHeader = false);
}