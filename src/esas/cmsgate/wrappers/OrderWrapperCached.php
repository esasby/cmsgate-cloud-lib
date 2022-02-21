<?php

namespace esas\cmsgate\wrappers;

use esas\cmsgate\cache\OrderCache;
use esas\cmsgate\CloudRegistry;
use esas\cmsgate\OrderStatus;

abstract class OrderWrapperCached extends OrderSafeWrapper
{
    /**
     * @var OrderCache
     */
    protected $orderCache;
    protected $products;

    /**
     * @param $order
     */
    public function __construct($orderCache)
    {
        parent::__construct();
        $this->orderCache = $orderCache;
    }

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     */
    public function getStatusUnsafe()
    {
        return new OrderStatus(
            $this->orderCache->getStatus(),
            $this->orderCache->getStatus());
    }

    /**
     * Обновляет статус заказа в БД
     * @param OrderStatus $newOrderStatus
     * @return mixed
     */
    public function updateStatus($newOrderStatus)
    {
        CloudRegistry::getRegistry()->getOrderCacheRepository()->setStatus($this->orderCache->getUuid(), $newOrderStatus->getOrderStatus());
    }

    /**
     * BillId (идентификатор хуткигрош) успешно выставленного счета
     * @return mixed
     */
    public function getExtIdUnsafe()
    {
        return $this->orderCache->getExtId();
    }

    /**
     * Сохраняет привязку внешнего идентификтора к заказу
     * @param $extId
     */
    public function saveExtId($extId)
    {
        $this->orderCache->setExtId($extId);
    }
}