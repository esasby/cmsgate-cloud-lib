<?php


namespace esas\cmsgate\cache;


use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\Logger;
use esas\cmsgate\utils\SessionUtils;

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

    public abstract function add($orderData, $configId);

    /**
     * @param $uuid string
     * @return OrderCache
     */
    public abstract function getByUUID($cacheUUID);

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

    public abstract function saveExtId($cacheUUID, $extId);

    public abstract function setStatus($cacheUUID, $status);

}