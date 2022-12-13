<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\BridgeConnector;

class OrderCache
{
    private $uuid;
    private $shopConfigId;
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
        $this->shopConfigId = $configId;
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
        BridgeConnector::fromRegistry()->getOrderCacheRepository()->saveExtId($this->uuid, $this->extId);
    }

    /**
     * @return mixed
     */
    public function getShopConfigId()
    {
        return $this->shopConfigId;
    }

    /**
     * @param mixed $shopConfigId
     */
    public function setShopConfigId($shopConfigId): void
    {
        $this->shopConfigId = $shopConfigId;
    }
}