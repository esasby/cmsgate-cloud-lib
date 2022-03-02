<?php


namespace esas\cmsgate\cache;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CloudSessionUtils;
use esas\cmsgate\utils\CMSGateException;

class OrderCacheService extends Service
{
    public function loadSessionOrderCacheByExtId($extId) {
        $orderCache = CloudRegistry::getRegistry()->getOrderCacheRepository()->getByExtId($extId);
        CloudSessionUtils::setOrderCacheObj($orderCache);
        CloudSessionUtils::setOrderCacheUUID($orderCache->getUuid());
    }

    public function addSessionOrderCache($orderData) {
        if ($orderData == null || empty($orderData))
            throw new CMSGateException('Incorrect request');
        $cache = CloudRegistry::getRegistry()->getOrderCacheRepository()->getByData($orderData);
        if ($cache != null) {
            CloudSessionUtils::setOrderCacheUUID($cache->getUuid());
            CloudSessionUtils::setOrderCacheObj($cache);
        } else {
            $uuid = CloudRegistry::getRegistry()->getOrderCacheRepository()->add($orderData, CloudSessionUtils::getConfigCacheUUID());
            CloudSessionUtils::setOrderCacheUUID($uuid);
        }
    }

    /**
     * @return OrderCache
     * @throws CMSGateException
     */
    public function getSessionOrderCache() {
        $cache = CloudSessionUtils::getOrderCacheObj();
        if ($cache != null)
            return $cache;
        $cacheUUID = CloudSessionUtils::getOrderCacheUUID();
        if ($cacheUUID == null || $cacheUUID === '')
            return null;
        $cache = CloudRegistry::getRegistry()->getOrderCacheRepository()->getByUUID($cacheUUID);
        CloudSessionUtils::setOrderCacheObj($cache);
        return $cache;
    }

    /**
     * @return OrderCache
     * @throws CMSGateException
     */
    public function getSessionOrderCacheSafe() {
        $cache = $this->getSessionOrderCache();
        if ($cache == null)
            throw new CMSGateException("Can not load cache from session");
        return $cache;
    }
}