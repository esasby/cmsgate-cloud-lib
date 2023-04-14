<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\BridgeConnector;

class OrderCache
{
    private $id;
    private $shopConfigId;
    private $status;
    /**
     * @var array
     */
    private $orderData;
    private $createdAt;
    private $extId;

    /**
     * @deprecated
     * @return mixed
     */
    public function getUuid()
    {
        return $this->getId();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return OrderCache
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShopConfigId() {
        return $this->shopConfigId;
    }

    /**
     * @param mixed $shopConfigId
     * @return OrderCache
     */
    public function setShopConfigId($shopConfigId) {
        $this->shopConfigId = $shopConfigId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return OrderCache
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrderData() {
        return $this->orderData;
    }

    /**
     * @param array $orderData
     * @return OrderCache
     */
    public function setOrderData($orderData) {
        $this->orderData = $orderData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return OrderCache
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtId() {
        return $this->extId;
    }

    /**
     * @param mixed $extId
     * @return OrderCache
     */
    public function setExtId($extId)
    {
        $this->extId = $extId;
        BridgeConnector::fromRegistry()->getOrderCacheRepository()->saveExtId($this->id, $this->extId);
        return $this;
    }
}