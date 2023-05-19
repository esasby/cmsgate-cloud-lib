<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\dao\ShopConfig;
use esas\cmsgate\bridge\dao\ShopConfigRepository;
use esas\cmsgate\bridge\security\CmsAuthService;
use esas\cmsgate\Registry;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CMSGateException;

class ShopConfigService extends Service
{
    /**
     * @return $this
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(ShopConfigService::class, new ShopConfigService());
    }

    public function checkAuthAndLoadConfig(&$request)
    {
        $shopConfig = CmsAuthService::fromRegistry()->checkAuth($request);
        SessionServiceBridge::fromRegistry()->setShopConfigObj($shopConfig);
        SessionServiceBridge::fromRegistry()->setShopConfigUUID($shopConfig->getId());
    }

    /**
     * @param $shopConfig ShopConfig
     */
    public function saveConfig($shopConfig) {
        ShopConfigRepository::fromRegistry()->saveOrUpdate($shopConfig);
        SessionServiceBridge::fromRegistry()->setShopConfigObj($shopConfig);
        SessionServiceBridge::fromRegistry()->setShopConfigUUID($shopConfig->getId());
    }

    /**
     * @return ShopConfig
     * @throws CMSGateException
     */
    public function getSessionShopConfig()
    {
        $shopConfig = SessionServiceBridge::fromRegistry()->getShopConfigObj();
        if ($shopConfig != null)
            return $shopConfig;
        $shopConfigId = SessionServiceBridge::fromRegistry()->getShopConfigUUID();
        if ($shopConfigId == null || $shopConfigId === '') {
            $order = OrderService::fromRegistry()->getSessionOrder();
            if ($order == null)
                return null;
            $shopConfigId = $order->getShopConfigId();
        }
        $shopConfig = ShopConfigRepository::fromRegistry()->getById($shopConfigId);
        SessionServiceBridge::fromRegistry()->setShopConfigObj($shopConfig);
        return $shopConfig;
    }

    /**
     * @return ShopConfig
     * @throws CMSGateException
     */
    public function getSessionShopConfigSafe()
    {
        $configCache = $this->getSessionShopConfig();
        if ($configCache == null)
            throw new CMSGateException("Can not load ShopConfig from session");
        return $configCache;
    }
}