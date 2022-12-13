<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 15.07.2019
 * Time: 13:14
 */

namespace esas\cmsgate;

use esas\cmsgate\bridge\ShopConfigBridge;
use esas\cmsgate\utils\SessionUtilsBridge;

class ConfigStorageBridge extends ConfigStorageCmsArray
{
    /**
     * @var ShopConfigBridge
     */
    protected $shopConfig;

    public function __construct()
    {
        parent::__construct($this->mergeConfigFromCache());
    }

    public function saveConfigs($keyValueArray)
    {
        BridgeConnector::fromRegistry()->getShopConfigRepository()->saveConfigData(SessionUtilsBridge::getShopConfigUUID(), $keyValueArray);
        $this->configArray = $keyValueArray;
    }

    protected function mergeConfigFromCache()
    {
        $orderCache = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCache();
        $this->shopConfig = BridgeConnector::fromRegistry()->getShopConfigService()->getSessionShopConfig(); // часть настроек может храниться в bridgeDB
        $configArray = array();
        if ($orderCache != null)
            $configArray = array_merge($configArray, $orderCache->getOrderData());
        if ($this->shopConfig != null)
            $configArray = array_merge($configArray, $this->shopConfig->getConfigArray());
        return $configArray;
    }

    public function getConfig($key)
    {
        if ($this->configArray == null || empty($this->configArray)) {
            $this->configArray = $this->mergeConfigFromCache();
        }
        if ($key == ConfigFields::sandbox()) {
            return BridgeConnector::fromRegistry()->isSandbox();
        } else
            return parent::getConfig($key);
    }


}