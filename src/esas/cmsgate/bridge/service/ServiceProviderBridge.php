<?php


namespace esas\cmsgate\bridge\service;


use esas\cmsgate\bridge\dao\MerchantRepository;
use esas\cmsgate\bridge\dao\MerchantRepositoryPDO;
use esas\cmsgate\bridge\dao\OrderRepository;
use esas\cmsgate\bridge\dao\OrderRepositoryPDO;
use esas\cmsgate\bridge\dao\ShopConfigBridgeRepositoryPDO;
use esas\cmsgate\bridge\dao\ShopConfigRepository;
use esas\cmsgate\bridge\security\CryptService;
use esas\cmsgate\bridge\security\CryptServiceImpl;
use esas\cmsgate\service\PDOService;
use esas\cmsgate\service\RedirectService;
use esas\cmsgate\service\ServiceProvider;

class ServiceProviderBridge implements ServiceProvider
{
    public function getServiceArray() {
        return array(
            CryptService::class => new CryptServiceImpl(),
            SessionServiceBridge::class => new SessionServiceBridgeImpl(),
            MerchantService::class => new  MerchantServiceBridge(),
            PDOService::class => new PDOServiceBridge(),
            RedirectService::class => new RedirectServiceBridge(),

            OrderRepository::class => new OrderRepositoryPDO(),
            ShopConfigRepository::class => new ShopConfigBridgeRepositoryPDO(),
            MerchantRepository::class => new MerchantRepositoryPDO(),
        );
    }
}