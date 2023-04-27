<?php


namespace esas\cmsgate\bridge\service;


use esas\cmsgate\bridge\dao\Merchant;
use esas\cmsgate\bridge\dao\OrderCache;
use esas\cmsgate\bridge\dao\ShopConfig;

class SessionServiceBridgeImpl extends SessionServiceBridge
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

    const SESSION_MERCHANT_UUID = 'merchant_UUID';

    public static function getMerchantUUID() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_MERCHANT_UUID])) ? $_SESSION[self::SESSION_MERCHANT_UUID] : null;
    }

    public static function setMerchantUUID($uuid) {
        $_SESSION[self::SESSION_MERCHANT_UUID] = $uuid;
    }

    const SESSION_SHOP_CONFIG_UUID = 'shop_config_UUID';

    public static function getShopConfigUUID() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_SHOP_CONFIG_UUID])) ? $_SESSION[self::SESSION_SHOP_CONFIG_UUID] : null;
    }

    public static function setShopConfigUUID($uuid) {
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

    const SESSION_MERCHANT_OBJECT = 'shop_merchant_obj';

    /**
     * @return Merchant
     */
    public static function getMerchantObj() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_MERCHANT_OBJECT])) ?  $_SESSION[self::SESSION_MERCHANT_OBJECT] : null;
    }

    public static function setMerchantObj($obj) {
        $_SESSION[self::SESSION_MERCHANT_OBJECT] = $obj;
    }
}