<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\bridge\dao\ShopConfig;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CMSGateException;

class ShopConfigService extends Service
{
    public function checkAuthAndLoadConfig(&$request)
    {
        $shopConfig = BridgeConnector::fromRegistry()->getCmsAuthService()->checkAuth($request);
        SessionServiceBridge::fromRegistry()::setShopConfigObj($shopConfig);
        SessionServiceBridge::fromRegistry()::setShopConfigUUID($shopConfig->getUuid());
    }

    public function saveConfig($shopConfig) {
        BridgeConnector::fromRegistry()->getShopConfigRepository()->saveOrUpdate($shopConfig);
        SessionServiceBridge::fromRegistry()::setShopConfigObj($shopConfig);
        SessionServiceBridge::fromRegistry()::setShopConfigUUID($shopConfig->getUuid());
    }

    /**
     * @return ShopConfig
     * @throws CMSGateException
     */
    public function getSessionShopConfig()
    {
        $shopConfig = SessionServiceBridge::fromRegistry()::getShopConfigObj();
        if ($shopConfig != null)
            return $shopConfig;
        $shopConfigId = SessionServiceBridge::fromRegistry()::getShopConfigUUID();
        if ($shopConfigId == null || $shopConfigId === '') {
            $orderCache = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCache();
            if ($orderCache == null)
                return null;
            $shopConfigId = $orderCache->getShopConfigId();
        }
        $shopConfig = BridgeConnector::fromRegistry()->getShopConfigRepository()->getById($shopConfigId);
        SessionServiceBridge::fromRegistry()::setShopConfigObj($shopConfig);
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