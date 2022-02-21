<?php


namespace esas\cmsgate;


use esas\cmsgate\cache\ConfigCacheRepository;
use esas\cmsgate\cache\ConfigCacheRepositoryPDO;
use esas\cmsgate\cache\OrderCacheRepository;
use esas\cmsgate\cache\OrderCacheRepositoryPDO;
use esas\cmsgate\utils\CMSGateException;

abstract class CloudRegistryPDO extends CloudRegistry
{
    /**
     * @return OrderCacheRepository
     * @throws CMSGateException
     */
    protected function createOrderCacheRepository() {
        return new OrderCacheRepositoryPDO($this->getPDO());
    }

    /**
     * @return ConfigCacheRepository
     * @throws CMSGateException
     */
    protected function createConfigCacheRepository() {
        return new ConfigCacheRepositoryPDO($this->getPDO());
    }

    public abstract function getPDO();
}