<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\dao\Order;
use esas\cmsgate\bridge\dao\OrderRepository;
use esas\cmsgate\Registry;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CMSGateException;

class OrderService extends Service
{
    /**
     * @inheritDoc
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(OrderService::class, new OrderService());
    }

    public function loadSessionOrderByExtId($extId) {
        $order = OrderRepository::fromRegistry()->getByExtId($extId);
        if ($order == null)
            throw new CMSGateException('Unknown external invoice id [' . $extId . "]");
        SessionServiceBridge::fromRegistry()->setOrderObj($order);
        SessionServiceBridge::fromRegistry()->setOrderUUID($order->getId());
    }

    public function loadSessionOrderById($id) {
        $order = OrderRepository::fromRegistry()->getByID($id);
        if ($order == null)
            throw new CMSGateException('Unknown order id [' . $id . "]");
        SessionServiceBridge::fromRegistry()->setOrderObj($order);
        SessionServiceBridge::fromRegistry()->setOrderUUID($order->getId());
        SessionServiceBridge::fromRegistry()->setShopConfigUUID($order->getShopConfigId());
    }

    /**
     * @param $order Order
     * @throws CMSGateException
     */
    public function addSessionOrder(&$order) {
        if ($order == null || empty($order) || $order->getOrderData() == null || empty($order->getOrderData()))
            throw new CMSGateException('Incorrect request');
        $cache = OrderRepository::fromRegistry()->getByData($order->getOrderData());
        if ($cache != null) {
            SessionServiceBridge::fromRegistry()->setOrderUUID($cache->getId());
            SessionServiceBridge::fromRegistry()->setOrderObj($cache);
        } else {
            if (empty($order->getShopConfigId()))
                $order->setShopConfigId(SessionServiceBridge::fromRegistry()->getShopConfigUUID());
            $orderId = OrderRepository::fromRegistry()->add($order);
            SessionServiceBridge::fromRegistry()->setOrderUUID($orderId);
            $order->setId($orderId);
        }
    }

    /**
     * @return Order
     * @throws CMSGateException
     */
    public function getSessionOrder() {
        $cache = SessionServiceBridge::fromRegistry()->getOrderObj();
        if ($cache != null)
            return $cache;
        $cacheUUID = SessionServiceBridge::fromRegistry()->getOrderUUID();
        if ($cacheUUID == null || $cacheUUID === '')
            return null;
        $cache = OrderRepository::fromRegistry()->getByID($cacheUUID);
        SessionServiceBridge::fromRegistry()->setOrderObj($cache);
        return $cache;
    }

    /**
     * @return Order
     * @throws CMSGateException
     */
    public function getSessionOrderSafe() {
        $cache = $this->getSessionOrder();
        if ($cache == null)
            throw new CMSGateException("Can not load cache from session");
        return $cache;
    }
}