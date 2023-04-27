<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\bridge\dao\ShopConfigBridgeRepository;

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