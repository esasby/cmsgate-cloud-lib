<?php

namespace esas\cmsgate\bridge\wrappers;

use esas\cmsgate\bridge\dao\Order;
use esas\cmsgate\bridge\dao\OrderRepository;
use esas\cmsgate\OrderStatus;
use esas\cmsgate\wrappers\OrderSafeWrapper;

abstract class OrderWrapperCached extends OrderSafeWrapper
{
    /**
     * @var Order
     */
    protected $order;
    /**
     * @param $order
     */
    public function __construct($order)
    {
        parent::__construct();
        $this->order = $order;
    }

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     */
    public function getStatusUnsafe()
    {
        return new OrderStatus(
            $this->order->getStatus(),
            $this->order->getStatus());
    }

    /**
     * Обновляет статус заказа в БД
     * @param OrderStatus $newOrderStatus
     * @return mixed
     */
    public function updateStatus($newOrderStatus)
    {
        OrderRepository::fromRegistry()->setStatus($this->order->getId(), $newOrderStatus->getOrderStatus());
    }

    /**
     * BillId (идентификатор хуткигрош) успешно выставленного счета
     * @return mixed
     */
    public function getExtIdUnsafe()
    {
        return $this->order->getExtId();
    }

    /**
     * Сохраняет привязку внешнего идентификтора к заказу
     * @param $extId
     */
    public function saveExtId($extId)
    {
        $this->order->setExtId($extId);
    }
}