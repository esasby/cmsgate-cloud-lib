<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 15.07.2019
 * Time: 13:14
 */

namespace esas\cmsgate\bridge;

use esas\cmsgate\bridge\dao\OrderStatusBridge;
use esas\cmsgate\bridge\dao\ShopConfigBridge;
use esas\cmsgate\bridge\dao\ShopConfigRepository;
use esas\cmsgate\bridge\properties\PropertiesBridge;
use esas\cmsgate\bridge\service\OrderService;
use esas\cmsgate\bridge\service\SessionServiceBridge;
use esas\cmsgate\bridge\service\ShopConfigService;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\ConfigStorageCmsArray;

class ConfigStorageBridge extends ConfigStorageCmsArray
{
    /**
     * @var ShopConfigBridge
     */
    protected $shopConfig;

    public function __construct()
    {
        parent::__construct($this->mergeConfigFromCache());
    }

    public function saveConfigs($keyValueArray)
    {
        ShopConfigRepository::fromRegistry()->saveConfigData(SessionServiceBridge::fromRegistry()->getShopConfigUUID(), $keyValueArray);
        $this->configArray = $keyValueArray;
    }

    protected function mergeConfigFromCache()
    {
        $order = OrderService::fromRegistry()->getSessionOrder();
        $this->shopConfig = ShopConfigService::fromRegistry()->getSessionShopConfig(); // часть настроек может храниться в bridgeDB
        $configArray = array();
        if ($order != null && is_array($order->getOrderData()))
            $configArray = array_merge($configArray, $order->getOrderData());
        if ($this->shopConfig != null && is_array($this->shopConfig->getConfigArray()))
            $configArray = array_merge($configArray, $this->shopConfig->getConfigArray());
        return $configArray;
    }

    public function getConfig($key)
    {
        if ($this->configArray == null || empty($this->configArray)) {
            $this->configArray = $this->mergeConfigFromCache();
        }
        if ($key == ConfigFields::sandbox()) {
            return PropertiesBridge::fromRegistry()->isSandbox();
        } else
            return parent::getConfig($key);
    }

    public function getConstantConfigValue($key) {
        switch ($key) {
            case ConfigFields::orderStatusPending():
            case ConfigFields::orderPaymentStatusPending():
                return OrderStatusBridge::PENDING;
            case ConfigFields::orderStatusPayed():
            case ConfigFields::orderPaymentStatusPayed():
                return OrderStatusBridge::PAYED;
            case ConfigFields::orderStatusFailed():
            case ConfigFields::orderPaymentStatusFailed():
                return OrderStatusBridge::FAILED;
            case ConfigFields::orderStatusCanceled():
            case ConfigFields::orderPaymentStatusCanceled():
                return OrderStatusBridge::CANCELED;;
            case ConfigFields::useOrderNumber():
                return true;
            default:
                return null;
        }
    }
}