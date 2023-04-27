<?php
namespace esas\cmsgate\bridge\dao;

use esas\cmsgate\utils\Logger;

abstract class OrderCacheRepository
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * OrderCacheRepository constructor.
     */
    public function __construct()
    {
        $this->logger = Logger::getLogger(get_class($this));

    }

    /**
     * @param $orderData array
     * @param $configId
     * @return mixed
     */
    public abstract function add($orderData, $configId);

    /**
     * @deprecated
     * @param $uuid string
     * @return OrderCache
     */
    public function getByUUID($cacheUUID) {
        return $this->getByID($cacheUUID);
    }

    /**
     * @param $orderId string
     * @return OrderCache
     */
    public abstract function getByID($orderId);

    /**
     * @param $extId string
     * @return OrderCache
     */
    public abstract function getByExtId($extId);

    /**
     * @param $orderData
     * @return OrderCache
     */
    public abstract function getByData($orderData);

    /**
     * @param $shopConfigId
     * @return OrderCache[]
     */
    public abstract function getByShopConfigId($shopConfigId);

    public abstract function saveExtId($cacheUUID, $extId);

    public abstract function setStatus($cacheUUID, $status);

}