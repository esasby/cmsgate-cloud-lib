<?php


namespace esas\cmsgate\cache;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\security\CryptService;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CloudSessionUtils;
use esas\cmsgate\utils\CMSGateException;

class ConfigCacheService extends Service
{
    public function checkAuthAndLoadConfig(&$request)
    {
        $configCache = CloudRegistry::getRegistry()->getApiAuthService()->checkAuth($request);
        CloudSessionUtils::setConfigCacheObj($configCache);
        CloudSessionUtils::setConfigCacheUUID($configCache->getUuid());
    }

    public function createNewSecret() {
        $cacheUUID = CloudSessionUtils::getConfigCacheUUID();
        if ($cacheUUID == null || $cacheUUID === '')
            throw new CMSGateException("Can not load ConfigCache from session");
        $newSecret = CryptService::generateCode(8);
        CloudRegistry::getRegistry()->getConfigCacheRepository()->saveSecret($cacheUUID, $newSecret);
    }

    /**
     * @return ConfigCache
     * @throws CMSGateException
     */
    public function getSessionConfigCache()
    {
        $configCache = CloudSessionUtils::getConfigCacheObj();
        if ($configCache != null)
            return $configCache;
        $cacheUUID = CloudSessionUtils::getConfigCacheUUID();
        if ($cacheUUID == null || $cacheUUID === '') {
            $orderCache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCache();
            if ($orderCache == null)
                return null;
            $cacheUUID = $orderCache->getConfigId();
        }
        $configCache = CloudRegistry::getRegistry()->getConfigCacheRepository()->getByUUID($cacheUUID);
        CloudSessionUtils::setConfigCacheObj($configCache);
        return $configCache;
    }

    /**
     * @return ConfigCache
     * @throws CMSGateException
     */
    public function getSessionConfigCacheSafe()
    {
        $configCache = $this->getSessionConfigCache();
        if ($configCache == null)
            throw new CMSGateException("Can not load ConfigCache from session");
        return $configCache;
    }
}