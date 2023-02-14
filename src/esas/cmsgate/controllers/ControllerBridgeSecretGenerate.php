<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\security\CryptService;
use esas\cmsgate\utils\SessionUtilsBridge;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\RedirectUtilsBridge;
use Exception;
use Throwable;

class ControllerBridgeSecretGenerate extends Controller
{
    public function process()
    {
        try {
            BridgeConnector::fromRegistry()->getMerchantService()->checkAuth(true);
            $this->createNewSecret();
        } catch (Throwable $e) {
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        } catch (Exception $e) { // для совместимости с php 5
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        }
        RedirectUtilsBridge::configPage(true);
    }

    public function createNewSecret() {
        $cacheUUID = SessionUtilsBridge::getShopConfigUUID();
        if ($cacheUUID == null || $cacheUUID === '')
            throw new CMSGateException("Can not load ConfigCache from session");
        $newSecret = CryptService::generateCode(8);
        BridgeConnector::fromRegistry()->getShopConfigRepository()->saveSecret($cacheUUID, $newSecret);
    }

}