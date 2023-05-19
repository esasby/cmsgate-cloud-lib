<?php
namespace esas\cmsgate\bridge\dao;

use esas\cmsgate\dao\Repository;
use esas\cmsgate\Registry;

abstract class OrderRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(OrderRepository::class);
    }

    /**
     * @param $order Order
     * @return mixed
     */
    public abstract function add($order);

    /**
     * @param $uuid string
     * @return Order
     *@deprecated
     */
    public function getByUUID($cacheUUID) {
        return $this->getByID($cacheUUID);
    }

    /**
     * @param $orderId string
     * @return Order
     */
    public abstract function getByID($orderId);

    /**
     * @param $extId string
     * @return Order
     */
    public abstract function getByExtId($extId);

    /**
     * @param $orderData
     * @return Order
     */
    public abstract function getByData($orderData);

    /**
     * @param $shopConfigId
     * @return Order[]
     */
    public abstract function getByShopConfigId($shopConfigId);

    public abstract function saveExtId($cacheUUID, $extId);

    public abstract function setStatus($cacheUUID, $status);

}