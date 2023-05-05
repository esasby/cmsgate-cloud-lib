<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 11:35
 */

namespace esas\cmsgate\bridge;


use esas\cmsgate\bridge\dao\MerchantRepository;
use esas\cmsgate\bridge\dao\OrderCacheRepository;
use esas\cmsgate\bridge\dao\ShopConfigRepository;
use esas\cmsgate\bridge\security\CmsAuthService;
use esas\cmsgate\bridge\security\CryptService;
use esas\cmsgate\bridge\security\CryptServiceImpl;
use esas\cmsgate\bridge\service\MerchantService;
use esas\cmsgate\bridge\service\OrderCacheService;
use esas\cmsgate\bridge\service\SessionServiceBridge;
use esas\cmsgate\bridge\service\SessionServiceBridgeImpl;
use esas\cmsgate\bridge\service\ShopConfigService;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;

abstract class BridgeConnector
{
    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function fromRegistry()
    {
        return Registry::getRegistry()->getService(BridgeConnector::class);
    }

    /**
     * @var OrderCacheRepository
     */
    protected $orderCacheRepository;

    /**
     * @var OrderCacheService
     */
    protected $orderCacheService;

    /**
     * @var CryptService
     */
    protected $cryptService;

    /**
     * @var ShopConfigRepository
     */
    protected $configCacheRepository;

    /**
     * @var ShopConfigService
     */
    protected $configCacheService;

    /**
     * @return OrderCacheRepository
     */
    public function getOrderCacheRepository() {
        if ($this->orderCacheRepository == null)
            $this->orderCacheRepository = $this->createOrderCacheRepository();
        return $this->orderCacheRepository;
    }

    /**
     * @return OrderCacheRepository
     * @throws CMSGateException
     */
    protected abstract function createOrderCacheRepository();

    /**
     * @return OrderCacheService
     */
    public function getOrderCacheService() {
        if ($this->orderCacheService == null)
            $this->orderCacheService = $this->createOrderCacheService();
        return $this->orderCacheService;
    }

    /**
     * @return OrderCacheService
     * @throws CMSGateException
     */
    protected function createOrderCacheService() {
        return new OrderCacheService();
    }

    /**
     * @return ShopConfigRepository
     */
    public function getShopConfigRepository() {
        if ($this->configCacheRepository == null)
            $this->configCacheRepository = $this->createShopConfigRepository();
        return $this->configCacheRepository;
    }

    /**
     * @return ShopConfigRepository
     * @throws CMSGateException
     */
    protected abstract function createShopConfigRepository();

    /**
     * @return CryptService
     */
    public function getCryptService() {
        if ($this->cryptService == null)
            $this->cryptService = $this->createCryptService();
        return $this->cryptService;
    }

    /**
     * @return CryptService
     * @throws CMSGateException
     */
    protected function createCryptService() {
        return new CryptServiceImpl();
    }

    /**
     * @return ShopConfigService
     */
    public function getShopConfigService() {
        if ($this->configCacheService == null)
            $this->configCacheService = $this->createShopConfigService();
        return $this->configCacheService;
    }

    /**
     * @return ShopConfigService
     * @throws CMSGateException
     */
    protected function createShopConfigService() {
        return new ShopConfigService();
    }

    public function isSandbox()
    {
        return false;
    }

    /**
     * @var CmsAuthService
     */
    protected $cmsAuthService;

    /**
     * @return CmsAuthService
     */
    public function getCmsAuthService() {
        if ($this->cmsAuthService == null)
            $this->cmsAuthService = $this->createCmsAuthService();
        return $this->cmsAuthService;
    }

    /**
     * @return CmsAuthService
     * @throws CMSGateException
     */
    protected abstract function createCmsAuthService();

    /**
     * @var MerchantService
     */
    protected $merchantService;

    /**
     * @return MerchantService
     * @throws CMSGateException
     */
    public function getMerchantService() {
        if ($this->merchantService == null)
            $this->merchantService = $this->createMerchantService();
        return $this->merchantService;
    }

    /**
     * @return MerchantService
     * @throws CMSGateException
     */
    protected abstract function createMerchantService();

    /**
     * @var MerchantRepository
     */
    protected $buyNowMerchantRepository;

    /**
     * @return MerchantRepository
     */
    public function getMerchantRepository() {
        if ($this->buyNowMerchantRepository == null)
            $this->buyNowMerchantRepository = $this->createMerchantRepository();
        return $this->buyNowMerchantRepository;
    }

    protected abstract function createMerchantRepository();

    /**
     * @var SessionServiceBridge
     */
    protected $sessionService;

    /**
     * @return SessionServiceBridge
     * @throws CMSGateException
     */
    public function getSessionService() {
        if ($this->sessionService == null)
            $this->sessionService = $this->createSessionService();
        return $this->sessionService;
    }

    /**
     * @return SessionServiceBridge
     * @throws CMSGateException
     */
    protected function createSessionService() {
        return new SessionServiceBridgeImpl();
    }
}