<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 15.07.2019
 * Time: 13:14
 */

namespace esas\cmsgate;

use esas\cmsgate\cache\ConfigCache;
use esas\cmsgate\utils\CloudSessionUtils;

class ConfigStorageCloud extends ConfigStorageCmsArray
{
    /**
     * @var ConfigCache
     */
    private $configCache;

    public function __construct()
    {
        parent::__construct($this->mergeConfigFromCache());
    }

    public function saveConfigs($keyValueArray)
    {
        CloudRegistry::getRegistry()->getConfigCacheRepository()->saveConfigData(CloudSessionUtils::getConfigCacheUUID(), $keyValueArray);
        $this->configArray = $keyValueArray;
    }

    protected function mergeConfigFromCache()
    {
        $orderCache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCache();
        $this->configCache = CloudRegistry::getRegistry()->getConfigCacheService()->getSessionConfigCache(); // часть настроек может храниться в облаке
        $configArray = array();
        if ($orderCache != null)
            $configArray = array_merge($configArray, $orderCache->getOrderData());
        if ($this->configCache != null)
            $configArray = array_merge($configArray, $this->configCache->getConfigArray());
        return $configArray;
    }

    public function getConfig($key)
    {
        if ($this->configArray == null || empty($this->configArray)) {
            $this->configArray = $this->mergeConfigFromCache();
        }
        if ($key == ConfigFields::sandbox()) {
            // cloud версии могут работать только в одном из режимов, задаваемом глобально для инстанции.
            // если необходим реальный и тестовый режим работы, необходимо поднимать две разных инстанции на разных адресах
            return CloudRegistry::getRegistry()->isSandbox();
        } elseif ($key == CloudRegistry::getRegistry()->getAuthConfigMapper()->getConfigFieldLogin())
            return $this->configCache->getLogin();
        elseif ($key == CloudRegistry::getRegistry()->getAuthConfigMapper()->getConfigFieldPassword())
            return $this->configCache->getPassword();
        else
            return parent::getConfig($key);
    }


}