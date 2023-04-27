<?php


namespace esas\cmsgate\bridge\controllers;


use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\bridge\security\CryptService;
use esas\cmsgate\bridge\service\SessionServiceBridge;
use esas\cmsgate\controllers\Controller;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;
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
        BridgeConnector::fromRegistry()->getMerchantService()->getRedirectService()->mainPage(true);
    }

    public function createNewSecret() {
        $cacheUUID = SessionServiceBridge::fromRegistry()::getShopConfigUUID();
        if ($cacheUUID == null || $cacheUUID === '')
            throw new CMSGateException("Can not load ConfigCache from session");
        $newSecret = CryptService::generateCode(8);
        BridgeConnector::fromRegistry()->getShopConfigRepository()->saveSecret($cacheUUID, $newSecret);
    }

}