<?php


namespace esas\cmsgate\utils;


use esas\cmsgate\bridge\ShopConfig;
use esas\cmsgate\bridge\OrderCache;

class SessionUtilsBridge
{
    const SESSION_ORDER_CACHE_UUID = 'order_cache_UUID';

    public static function getOrderCacheUUID() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_ORDER_CACHE_UUID])) ? $_SESSION[self::SESSION_ORDER_CACHE_UUID] : null;
    }

    public static function setOrderCacheUUID($uuid) {
        $_SESSION[self::SESSION_ORDER_CACHE_UUID] = $uuid;
    }

    const SESSION_ORDER_CACHE_OBJECT = 'order_cache_obj';

    /**
     * @return OrderCache
     */
    public static function getOrderCacheObj() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_ORDER_CACHE_OBJECT]))  ? $_SESSION[self::SESSION_ORDER_CACHE_OBJECT] : null;
    }

    public static function setOrderCacheObj($obj) {
        $_SESSION[self::SESSION_ORDER_CACHE_OBJECT] = $obj;
    }

    const SESSION_SHOP_CONFIG_UUID = 'shop_config_UUID';

    public static function getShopConfigUUID() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_SHOP_CONFIG_UUID])) ? $_SESSION[self::SESSION_SHOP_CONFIG_UUID] : null;
    }

    public static function setConfigCacheUUID($uuid) {
        $_SESSION[self::SESSION_SHOP_CONFIG_UUID] = $uuid;
    }

    const SESSION_SHOP_CONFIG_OBJECT = 'shop_config_obj';

    /**
     * @return ShopConfig
     */
    public static function getShopConfigObj() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_SHOP_CONFIG_OBJECT])) ?  $_SESSION[self::SESSION_SHOP_CONFIG_OBJECT] : null;
    }

    public static function setShopConfigObj(ShopConfig $obj) {
        $_SESSION[self::SESSION_SHOP_CONFIG_OBJECT] = $obj;
    }
}