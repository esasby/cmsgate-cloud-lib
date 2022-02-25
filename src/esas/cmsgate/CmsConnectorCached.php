<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 13.04.2020
 * Time: 12:23
 */

namespace esas\cmsgate;

use esas\cmsgate\wrappers\OrderWrapper;
use Exception;

abstract class CmsConnectorCached extends CmsConnector
{
    public function createCommonConfigForm($managedFields)
    {
        throw new Exception('Not implemented');
    }

    public function createSystemSettingsWrapper()
    {
        throw new Exception('Not implemented');
    }

    /**
     * По локальному id заказа возвращает wrapper
     * @param $orderId
     * @return OrderWrapper
     */
    public function createOrderWrapperByOrderId($orderId)
    {
        return $this->createOrderWrapperForCurrentUser();
    }

    public function createOrderWrapperForCurrentUser()
    {
        $cache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCacheSafe();
        return $this->createOrderWrapperCached($cache);
    }

    public abstract function createOrderWrapperCached($cache);

    public function createOrderWrapperByOrderNumber($orderNumber)
    {
        return $this->createOrderWrapperForCurrentUser();
    }

    public function createOrderWrapperByExtId($extId)
    {
        return CloudRegistry::getRegistry()->getOrderCacheRepository()->getByExtId($extId);
    }

    public function createConfigStorage()
    {
        return new ConfigStorageCloud();
    }


    public function createLocaleLoader()
    {
        $cache = CloudRegistry::getRegistry()->getOrderCacheService()->getSessionOrderCache();
        return $this->createLocaleLoaderCached($cache);
    }

    public abstract function createLocaleLoaderCached($cache);
}