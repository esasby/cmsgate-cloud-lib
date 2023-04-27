<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\bridge\dao\MerchantRepositoryPDO;
use esas\cmsgate\bridge\dao\OrderCacheRepository;
use esas\cmsgate\bridge\dao\OrderCacheRepositoryPDO;
use esas\cmsgate\bridge\dao\ShopConfigBridgeRepositoryPDO;
use esas\cmsgate\bridge\dao\ShopConfigRepository;
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
    protected function createShopConfigRepository() {
        return new ShopConfigBridgeRepositoryPDO($this->getPDO());
    }

    /**
     * @inheritDoc
     */
    protected function createMerchantRepository() {
        return new MerchantRepositoryPDO($this->getPDO());
    }

    public abstract function getPDO();
}