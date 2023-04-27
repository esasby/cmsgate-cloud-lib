<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 13.04.2020
 * Time: 12:23
 */

namespace esas\cmsgate\bridge;

use esas\cmsgate\CmsConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\wrappers\OrderWrapper;
use Exception;

abstract class CmsConnectorBridge extends CmsConnector
{
    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function fromRegistry()
    {
        return Registry::getRegistry()->getCmsConnector();
    }

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
        $cache = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCacheSafe();
        return $this->createOrderWrapperCached($cache);
    }

    public abstract function createOrderWrapperCached($cache);

    public function createOrderWrapperByOrderNumber($orderNumber)
    {
        return $this->createOrderWrapperForCurrentUser();
    }

    public function createOrderWrapperByExtId($extId)
    {
        return BridgeConnector::fromRegistry()->getOrderCacheRepository()->getByExtId($extId);
    }

    public function createConfigStorage()
    {
        return new ConfigStorageBridge();
    }


    public function createLocaleLoader()
    {
        $cache = BridgeConnector::fromRegistry()->getOrderCacheService()->getSessionOrderCache();
        return $this->createLocaleLoaderCached($cache);
    }

    public abstract function createLocaleLoaderCached($cache);


}