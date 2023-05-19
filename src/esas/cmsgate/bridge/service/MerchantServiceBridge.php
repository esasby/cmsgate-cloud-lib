<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\dao\ShopConfigBridgeRepository;
use esas\cmsgate\bridge\dao\ShopConfigRepository;

class MerchantServiceBridge extends MerchantService
{
    public function addOrUpdateAuth($login, $password, $hash) {
        /** @var ShopConfigBridgeRepository $shopConfigRepository */
        $shopConfigRepository = ShopConfigRepository::fromRegistry();
        return $shopConfigRepository->addOrUpdateAuth($login, $password, $hash);
    }

    public function getAuthHashById($id) {
        /** @var ShopConfigBridgeRepository $shopConfigRepository */
        $shopConfigRepository = ShopConfigRepository::fromRegistry();
        return $shopConfigRepository->getAuthHashById($id);
    }
}