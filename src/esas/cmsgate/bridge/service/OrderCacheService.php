<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\bridge\dao\OrderCache;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CMSGateException;

class OrderCacheService extends Service
{
    public function loadSessionOrderCacheByExtId($extId) {
        $orderCache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByExtId($extId);
        if ($orderCache == null)
            throw new CMSGateException('Unknown external invoice id [' . $extId . "]");
        SessionServiceBridge::fromRegistry()::setOrderCacheObj($orderCache);
        SessionServiceBridge::fromRegistry()::setOrderCacheUUID($orderCache->getUuid());
    }

    public function loadSessionOrderCacheById($id) {
        $orderCache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByID($id);
        if ($orderCache == null)
            throw new CMSGateException('Unknown order id [' . $id . "]");
        SessionServiceBridge::fromRegistry()::setOrderCacheObj($orderCache);
        SessionServiceBridge::fromRegistry()::setOrderCacheUUID($orderCache->getUuid());
        SessionServiceBridge::fromRegistry()::setShopConfigUUID($orderCache->getShopConfigId());
    }

    public function addSessionOrderCache($orderData) {
        if ($orderData == null || empty($orderData))
            throw new CMSGateException('Incorrect request');
        $cache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByData($orderData);
        if ($cache != null) {
            SessionServiceBridge::fromRegistry()::setOrderCacheUUID($cache->getUuid());
            SessionServiceBridge::fromRegistry()::setOrderCacheObj($cache);
        } else {
            $uuid = BridgeConnector::fromRegistry()->getOrderCacheRepository()->add($orderData, SessionServiceBridge::fromRegistry()::getShopConfigUUID());
            SessionServiceBridge::fromRegistry()::setOrderCacheUUID($uuid);
        }
    }

    /**
     * @return OrderCache
     * @throws CMSGateException
     */
    public function getSessionOrderCache() {
        $cache = SessionServiceBridge::fromRegistry()::getOrderCacheObj();
        if ($cache != null)
            return $cache;
        $cacheUUID = SessionServiceBridge::fromRegistry()::getOrderCacheUUID();
        if ($cacheUUID == null || $cacheUUID === '')
            return null;
        $cache = BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByID($cacheUUID);
        SessionServiceBridge::fromRegistry()::setOrderCacheObj($cache);
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