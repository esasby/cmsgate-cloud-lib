<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\utils\RedirectUtilsCloud;
use esas\cmsgate\view\admin\CookieCloud;

class ControllerCloudLogout extends Controller
{
    public function process() {
        setcookie(CookieCloud::ID, "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie(CookieCloud::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
        RedirectUtilsCloud::loginPage(true);
    }
}