<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\view\client\CookieCloud;

class ControllerCloudLogout extends Controller
{
    public function process() {
        setcookie(CookieCloud::ID, "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie(CookieCloud::HASH, "", time() - 3600 * 24 * 30 * 12, "/", null, null, true); // httponly !!!
    }
}