<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 15.07.2019
 * Time: 13:14
 */

namespace esas\cmsgate;

use esas\cmsgate\utils\CloudSessionUtils;

class ConfigStorageCloud extends ConfigStorageCmsArray
{
    public function __construct()
    {
        parent::__construct($this->mergeConfigFromCache());
    }

    public function saveConfigs($keyValueArray)
    {
        CloudRegistry::getRegistry()->getConfigCacheRepository()->saveConfigData(CloudSessionUtils::getConfigCacheUUID(), $keyValueArray);
    }

    protected function mergeConfigFromCache() {
        $orderCache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCache();
        $configCache = CloudRegistry::getRegistry()->getConfigCacheService()->getSessionConfigCache(); // часть настроек может храниться в облаке
        $configArray = array();
        if ($orderCache != null)
            $configArray = array_merge($configArray, $orderCache->getOrderData());
        if ($configCache != null)
            $configArray = array_merge($configArray, $configCache->getConfigArray());
        return $configArray;
    }
}