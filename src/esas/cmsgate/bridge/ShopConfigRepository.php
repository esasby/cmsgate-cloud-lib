<?php


namespace esas\cmsgate\bridge;


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
    public function __construct()
    {
        $this->logger = Logger::getLogger(get_class($this));

    }

    /**
     * @param $cacheConfigUUID
     * @return ShopConfig
     */
    public abstract function getByUUID($cacheConfigUUID);
}