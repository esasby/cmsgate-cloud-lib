<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\BridgeConnector;

abstract class MerchantServiceBridge extends MerchantService
{
    public function addOrUpdateAuth($login, $password, $hash) {
        /** @var ShopConfigBridgeRepository $shopConfigRepository */
        $shopConfigRepository = BridgeConnector::fromRegistry()->getShopConfigRepository();
        return $shopConfigRepository->addOrUpdateAuth($login, $password, $hash);
    }

    public function getAuthHashById($id) {
        /** @var ShopConfigBridgeRepository $shopConfigRepository */
        $shopConfigRepository = BridgeConnector::fromRegistry()->getShopConfigRepository();
        return $shopConfigRepository->getAuthHashById($id);
    }
}