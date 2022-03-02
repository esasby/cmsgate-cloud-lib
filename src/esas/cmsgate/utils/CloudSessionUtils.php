<?php


namespace esas\cmsgate\utils;


use esas\cmsgate\cache\ConfigCache;
use esas\cmsgate\cache\OrderCache;

class CloudSessionUtils
{
    const SESSION_ORDER_CACHE_UUID = 'order_cache_UUID';

    public static function getOrderCacheUUID() {
        return isset($_SESSION) ? $_SESSION[self::SESSION_ORDER_CACHE_UUID] : null;
    }

    public static function setOrderCacheUUID($uuid) {
        $_SESSION[self::SESSION_ORDER_CACHE_UUID] = $uuid;
    }

    const SESSION_ORDER_CACHE_OBJECT = 'order_cache_obj';

    /**
     * @return OrderCache
     */
    public static function getOrderCacheObj() {
        return isset($_SESSION) ? $_SESSION[self::SESSION_ORDER_CACHE_OBJECT] : null;
    }

    public static function setOrderCacheObj($obj) {
        $_SESSION[self::SESSION_ORDER_CACHE_OBJECT] = $obj;
    }

    const SESSION_CONFIG_CACHE_UUID = 'config_cache_UUID';

    public static function getConfigCacheUUID() {
        return isset($_SESSION) ? $_SESSION[self::SESSION_CONFIG_CACHE_UUID] : null;
    }

    public static function setConfigCacheUUID($uuid) {
        $_SESSION[self::SESSION_CONFIG_CACHE_UUID] = $uuid;
    }

    const SESSION_CONFIG_CACHE_OBJECT = 'config_cache_obj';

    /**
     * @return ConfigCache
     */
    public static function getConfigCacheObj() {
        return isset($_SESSION) ?  $_SESSION[self::SESSION_CONFIG_CACHE_OBJECT] : null;
    }

    public static function setConfigCacheObj(ConfigCache $obj) {
        $_SESSION[self::SESSION_CONFIG_CACHE_OBJECT] = $obj;
    }
}