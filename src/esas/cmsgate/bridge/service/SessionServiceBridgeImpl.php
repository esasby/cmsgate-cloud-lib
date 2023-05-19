<?php


namespace esas\cmsgate\bridge\service;


use esas\cmsgate\bridge\dao\Merchant;
use esas\cmsgate\bridge\dao\Order;
use esas\cmsgate\bridge\dao\ShopConfig;

class SessionServiceBridgeImpl extends SessionServiceBridge
{
    const SESSION_ORDER_CACHE_UUID = 'order_cache_UUID';

    public function getOrderUUID() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_ORDER_CACHE_UUID])) ? $_SESSION[self::SESSION_ORDER_CACHE_UUID] : null;
    }

    public function setOrderUUID($uuid) {
        $_SESSION[self::SESSION_ORDER_CACHE_UUID] = $uuid;
    }

    const SESSION_ORDER_CACHE_OBJECT = 'order_cache_obj';

    /**
     * @return Order
     */
    public function getOrderObj() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_ORDER_CACHE_OBJECT]))  ? $_SESSION[self::SESSION_ORDER_CACHE_OBJECT] : null;
    }

    public function setOrderObj($obj) {
        $_SESSION[self::SESSION_ORDER_CACHE_OBJECT] = $obj;
    }

    const SESSION_MERCHANT_UUID = 'merchant_UUID';

    public function getMerchantUUID() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_MERCHANT_UUID])) ? $_SESSION[self::SESSION_MERCHANT_UUID] : null;
    }

    public function setMerchantUUID($uuid) {
        $_SESSION[self::SESSION_MERCHANT_UUID] = $uuid;
    }

    const SESSION_SHOP_CONFIG_UUID = 'shop_config_UUID';

    public function getShopConfigUUID() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_SHOP_CONFIG_UUID])) ? $_SESSION[self::SESSION_SHOP_CONFIG_UUID] : null;
    }

    public function setShopConfigUUID($uuid) {
        $_SESSION[self::SESSION_SHOP_CONFIG_UUID] = $uuid;
    }

    const SESSION_SHOP_CONFIG_OBJECT = 'shop_config_obj';

    /**
     * @return ShopConfig
     */
    public function getShopConfigObj() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_SHOP_CONFIG_OBJECT])) ?  $_SESSION[self::SESSION_SHOP_CONFIG_OBJECT] : null;
    }

    public function setShopConfigObj(ShopConfig $obj) {
        $_SESSION[self::SESSION_SHOP_CONFIG_OBJECT] = $obj;
    }

    const SESSION_MERCHANT_OBJECT = 'shop_merchant_obj';

    /**
     * @return Merchant
     */
    public function getMerchantObj() {
        return (isset($_SESSION) && isset($_SESSION[self::SESSION_MERCHANT_OBJECT])) ?  $_SESSION[self::SESSION_MERCHANT_OBJECT] : null;
    }

    public function setMerchantObj($obj) {
        $_SESSION[self::SESSION_MERCHANT_OBJECT] = $obj;
    }
}