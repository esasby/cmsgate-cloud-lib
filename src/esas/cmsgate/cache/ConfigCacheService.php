<?php


namespace esas\cmsgate\cache;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CloudSessionUtils;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\Logger;

class ConfigCacheService extends Service
{
    public function checkAuthAndLoadConfig(&$request)
    {
        $configCache = CloudRegistry::getRegistry()->getApiAuthService()->checkAuth($request);
        CloudSessionUtils::setConfigCacheObj($configCache);
        CloudSessionUtils::setConfigCacheUUID($configCache->getUuid());
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
        if ($cacheUUID == null || $cacheUUID === '')
            throw new CMSGateException('ConfigCache Id can not be found in session');
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