<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\view\admin\CookieCloud;

class ControllerCloudConfig extends Controller
{
    public function process()
    {
        (new ControllerCloudCheckAuth())->process();
        $adminConfigPage = CloudRegistry::getRegistry()->getAdminConfigPage();
        $adminConfigPage->render();
    }
}