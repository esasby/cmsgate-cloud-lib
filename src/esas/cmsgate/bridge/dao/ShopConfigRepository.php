<?php
namespace esas\cmsgate\bridge\dao;

use esas\cmsgate\dao\Repository;
use esas\cmsgate\Registry;

abstract class ShopConfigRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(ShopConfigRepository::class);
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