<?php


namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\dao\Merchant;
use esas\cmsgate\bridge\dao\Order;
use esas\cmsgate\bridge\dao\ShopConfig;
use esas\cmsgate\Registry;
use esas\cmsgate\service\Service;

abstract class SessionServiceBridge extends Service
{
    /**
     * @return $this
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(SessionServiceBridge::class);
    }

    public abstract function getOrderUUID();

    public abstract function setOrderUUID($uuid);

    /**
     * @return Order
     */
    public abstract function getOrderObj();

    public abstract function setOrderObj($obj);

    public abstract function getMerchantUUID();

    public abstract function setMerchantUUID($uuid) ;

    public abstract function getShopConfigUUID();

    public abstract function setShopConfigUUID($uuid);

    /**
     * @return ShopConfig
     */
    public abstract function getShopConfigObj();

    public abstract function setShopConfigObj(ShopConfig $obj);

    /**
     * @return Merchant
     */
    public abstract function getMerchantObj();

    public abstract function setMerchantObj($obj);
}