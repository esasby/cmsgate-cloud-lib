<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\SessionUtilsBridge;
use esas\cmsgate\utils\CMSGateException;

class OrderCacheService extends Service
{
    public function loadSessionOrderCacheByExtId($extId) {
        $orderCache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByExtId($extId);
        if ($orderCache == null)
            throw new CMSGateException('Unknown external invoice id [' . $extId . "]");
        SessionUtilsBridge::setOrderCacheObj($orderCache);
        SessionUtilsBridge::setOrderCacheUUID($orderCache->getUuid());
    }

    public function loadSessionOrderCacheById($id) {
        $orderCache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByID($id);
        if ($orderCache == null)
            throw new CMSGateException('Unknown order id [' . $id . "]");
        SessionUtilsBridge::setOrderCacheObj($orderCache);
        SessionUtilsBridge::setOrderCacheUUID($orderCache->getUuid());
        SessionUtilsBridge::setShopConfigUUID($orderCache->getShopConfigId());
    }

    public function addSessionOrderCache($orderData) {
        if ($orderData == null || empty($orderData))
            throw new CMSGateException('Incorrect request');
        $cache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByData($orderData);
        if ($cache != null) {
            SessionUtilsBridge::setOrderCacheUUID($cache->getUuid());
            SessionUtilsBridge::setOrderCacheObj($cache);
        } else {
            $uuid = BridgeConnector::fromRegistry()->getOrderCacheRepository()->add($orderData, SessionUtilsBridge::getShopConfigUUID());
            SessionUtilsBridge::setOrderCacheUUID($uuid);
        }
    }

    /**
     * @return OrderCache
     * @throws CMSGateException
     */
    public function getSessionOrderCache() {
        $cache = SessionUtilsBridge::getOrderCacheObj();
        if ($cache != null)
            return $cache;
        $cacheUUID = SessionUtilsBridge::getOrderCacheUUID();
        if ($cacheUUID == null || $cacheUUID === '')
            return null;
        $cache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByID($cacheUUID);
        SessionUtilsBridge::setOrderCacheObj($cache);
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