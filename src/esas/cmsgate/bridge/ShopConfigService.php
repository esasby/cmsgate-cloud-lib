<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\SessionUtilsBridge;
use esas\cmsgate\utils\CMSGateException;

class ShopConfigService extends Service
{
    public function checkAuthAndLoadConfig(&$request)
    {
        $shopConfig = BridgeConnector::fromRegistry()->getCmsAuthService()->checkAuth($request);
        SessionUtilsBridge::setShopConfigObj($shopConfig);
        SessionUtilsBridge::setShopConfigUUID($shopConfig->getUuid());
    }

    public function saveConfig($shopConfig) {
        BridgeConnector::fromRegistry()->getShopConfigRepository()->saveOrUpdate($shopConfig);
        SessionUtilsBridge::setShopConfigObj($shopConfig);
        SessionUtilsBridge::setShopConfigUUID($shopConfig->getUuid());
    }

    /**
     * @return ShopConfig
     * @throws CMSGateException
     */
    public function getSessionShopConfig()
    {
        $shopConfig = SessionUtilsBridge::getShopConfigObj();
        if ($shopConfig != null)
            return $shopConfig;
        $shopConfigId = SessionUtilsBridge::getShopConfigUUID();
        if ($shopConfigId == null || $shopConfigId === '') {
            $orderCache = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCache();
            if ($orderCache == null)
                return null;
            $shopConfigId = $orderCache->getShopConfigId();
        }
        $shopConfig = BridgeConnector::fromRegistry()->getShopConfigRepository()->getByUUID($shopConfigId);
        SessionUtilsBridge::setShopConfigObj($shopConfig);
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