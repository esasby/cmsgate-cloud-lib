<?php


namespace esas\cmsgate;


use esas\cmsgate\bridge\ShopConfigBridgeRepositoryPDO;
use esas\cmsgate\bridge\ShopConfigRepository;
use esas\cmsgate\bridge\OrderCacheRepository;
use esas\cmsgate\bridge\OrderCacheRepositoryPDO;
use esas\cmsgate\utils\CMSGateException;

abstract class BridgeConnectorPDO extends BridgeConnector
{
    /**
     * @return OrderCacheRepository
     * @throws CMSGateException
     */
    protected function createOrderCacheRepository() {
        return new OrderCacheRepositoryPDO($this->getPDO());
    }

    /**
     * @return ShopConfigRepository
     * @throws CMSGateException
     */
    protected function createConfigCacheRepository() {
        return new ShopConfigBridgeRepositoryPDO($this->getPDO());
    }

    public abstract function getPDO();
}