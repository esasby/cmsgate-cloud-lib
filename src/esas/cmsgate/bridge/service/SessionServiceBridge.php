<?php


namespace esas\cmsgate\bridge\service;


use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\bridge\dao\Merchant;
use esas\cmsgate\bridge\dao\OrderCache;
use esas\cmsgate\bridge\dao\ShopConfig;

abstract class SessionServiceBridge
{
    /**
     * @return $this
     */
    public static function fromRegistry() {
        return BridgeConnector::fromRegistry()->getSessionService();
    }

    public abstract static function getOrderCacheUUID();

    public abstract static function setOrderCacheUUID($uuid);

    /**
     * @return OrderCache
     */
    public abstract static function getOrderCacheObj();

    public abstract static function setOrderCacheObj($obj);

    public abstract static function getMerchantUUID();

    public abstract static function setMerchantUUID($uuid) ;

    public abstract static function getShopConfigUUID();

    public abstract static function setShopConfigUUID($uuid);

    /**
     * @return ShopConfig
     */
    public abstract static function getShopConfigObj();

    public abstract static function setShopConfigObj(ShopConfig $obj);

    /**
     * @return Merchant
     */
    public abstract static function getMerchantObj();

    public abstract static function setMerchantObj($obj);
}