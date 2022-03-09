<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use Exception;
use Throwable;

class ControllerCloudConfig extends Controller
{
    public function process()
    {
        (new ControllerCloudCheckAuth())->process(true);
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Registry::getRegistry()->getConfigForm()->validate();
                Registry::getRegistry()->getConfigForm()->save();
            }
        } catch (Throwable $e) {
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        } catch (Exception $e) { // для совместимости с php 5
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        }
        CloudRegistry::getRegistry()->getAdminConfigPage()->render();
    }
}