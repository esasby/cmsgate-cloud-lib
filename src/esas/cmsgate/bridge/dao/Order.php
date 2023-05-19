<?php
namespace esas\cmsgate\bridge\dao;

class Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @param $orderData mixed
     * @return Order
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
     * @return Order
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
     * @return Order
     */
    public function setExtId($extId)
    {
        $this->extId = $extId;
        OrderRepository::fromRegistry()->saveExtId($this->id, $this->extId);
        return $this;
    }
}