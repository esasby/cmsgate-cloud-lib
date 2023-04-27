<?php

namespace esas\cmsgate\bridge\dao;

use esas\cmsgate\OrderStatus;

class OrderStatusBridge
{
    const PENDING = 'cmsgate_pending';
    const PAYED = 'cmsgate_payed';
    const FAILED = 'cmsgate_failed';
    const CANCELED = 'cmsgate_canceled';

    public static function pending()
    {
        return new OrderStatus(
            self::PENDING,
            self::PENDING);
    }

    public static function payed()
    {
        return new OrderStatus(
            self::PAYED,
            self::PAYED);
    }

    public static function failed()
    {
        return new OrderStatus(
            self::FAILED,
            self::FAILED);
    }

    public static function canceled()
    {
        return new OrderStatus(
            self::CANCELED,
            self::CANCELED);
    }
}