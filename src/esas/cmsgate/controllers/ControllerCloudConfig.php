<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\RedirectUtilsCloud;
use esas\cmsgate\view\admin\CookieCloud;
use Exception;
use Throwable;

class ControllerCloudConfig extends Controller
{
    public function process()
    {
        (new ControllerCloudCheckAuth())->process(true);
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $adminConfigPage = CloudRegistry::getRegistry()->getAdminConfigPage();
                    $adminConfigPage->render();
                    break;
                case 'POST':
                    Registry::getRegistry()->getConfigForm()->save();
                    RedirectUtilsCloud::configPage(true);
                    break;
            }
        } catch (Throwable $e) {
            CloudRegistry::getRegistry()->getAdminConfigPage();
        } catch (Exception $e) { // для совместимости с php 5
            CloudRegistry::getRegistry()->getAdminConfigPage();
        }

    }
}