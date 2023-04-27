<?php
namespace esas\cmsgate\bridge\dao;

use esas\cmsgate\utils\Logger;

abstract class ShopConfigRepository
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * OrderCacheRepository constructor.
     */
    public function __construct() {
        $this->logger = Logger::getLogger(get_class($this));

    }

    /**
     * @deprecated
     * @param $cacheConfigUUID
     * @return ShopConfig
     */
    public function getByUUID($cacheConfigUUID) {
        return $this->getById($cacheConfigUUID);
    }

    /**
     * @param $shopConfigId
     * @return ShopConfig
     */
    public abstract function getById($shopConfigId);

    /**
     * @param $shopConfig ShopConfig
     */
    public abstract function saveOrUpdate($shopConfig);

    public abstract function saveConfigData($configCacheUUID, $configData);
}