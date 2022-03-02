<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\RedirectUtilsCloud;
use Exception;
use Throwable;

class ControllerCloudSecretGenerate extends Controller
{
    public function process()
    {
        try {
            (new ControllerCloudCheckAuth())->process(true);
            CloudRegistry::getRegistry()->getConfigCacheService()->createNewSecret();
        } catch (Throwable $e) {
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        } catch (Exception $e) { // для совместимости с php 5
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        }
        RedirectUtilsCloud::configPage(true);
    }

}