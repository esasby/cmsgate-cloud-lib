<?php


namespace esas\cmsgate\cache;


use esas\cmsgate\CloudRegistry;

class OrderCache
{
    private $uuid;
    private $configId;
    private $status;
    /**
     * @var array
     */
    private $orderData;
    private $extId;

    /**
     * OrderCache constructor.
     * @param $uuid
     * @param $orderData
     * @param $extId
     */
    public function __construct($uuid, $configId, $orderData, $extId, $status)
    {
        $this->uuid = $uuid;
        $this->configId = $configId;
        $this->orderData = $orderData;
        $this->extId = $extId;
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return array
     */
    public function getOrderData()
    {
        return $this->orderData;
    }

    /**
     * @return mixed
     */
    public function getExtId()
    {
        return $this->extId;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $extId
     */
    public function setExtId($extId)
    {
        $this->extId = $extId;
        CloudRegistry::getRegistry()->getOrderCacheRepository()->saveExtId($this->uuid, $this->extId);
    }

    /**
     * @return mixed
     */
    public function getConfigId()
    {
        return $this->configId;
    }

    /**
     * @param mixed $configId
     */
    public function setConfigId($configId): void
    {
        $this->configId = $configId;
    }
}