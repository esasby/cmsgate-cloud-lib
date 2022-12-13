<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 11:35
 */

namespace esas\cmsgate;


use esas\cmsgate\bridge\OrderCacheRepository;
use esas\cmsgate\bridge\OrderCacheService;
use esas\cmsgate\security\CmsAuthService;
use esas\cmsgate\security\CryptService;
use esas\cmsgate\security\CryptServiceImpl;
use esas\cmsgate\bridge\ShopConfigService;
use esas\cmsgate\bridge\ShopConfigRepository;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\view\admin\AdminConfigPage;
use esas\cmsgate\view\admin\AdminLoginPage;

abstract class BridgeConnector
{
    const BRIDGE_CONNECTOR_SERVICE_NAME = 'BridgeConnector';
    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function fromRegistry()
    {
        return Registry::getRegistry()->getService(BRIDGE_CONNECTOR_SERVICE_NAME);
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
     * @var AdminLoginPage
     */
    protected $adminLoginPage;

    /**
     * @var AdminConfigPage
     */
    protected $adminConfigPage;

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
            $this->configCacheRepository = $this->createConfigCacheRepository();
        return $this->configCacheRepository;
    }

    /**
     * @return ShopConfigRepository
     * @throws CMSGateException
     */
    protected abstract function createConfigCacheRepository();

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
     * @return AdminLoginPage
     */
    public function getAdminLoginPage()
    {
        if ($this->adminLoginPage != null)
            return $this->adminLoginPage;
        else
            $this->adminLoginPage = $this->createAdminLoginPage();
        return $this->adminLoginPage;
    }

    public abstract function createAdminLoginPage();

    /**
     * @return AdminConfigPage
     */
    public function getAdminConfigPage()
    {
        if ($this->adminConfigPage != null)
            return $this->adminConfigPage;
        else
            $this->adminConfigPage = $this->createAdminConfigPage();
        return $this->adminConfigPage;
    }

    public abstract function createAdminConfigPage();

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

    public function getBridgeUrlReal() {
        return sprintf('https://cmsgate.esas.by/cmsgate-%s', Registry::getRegistry()->getModuleDescriptor()->getCmsAndPaysystemName('-')); //todo fix
    }

    public function getBridgeUrlSandbox() {
        return sprintf('https://test-cmsgate.esas.by/cmsgate-%s', Registry::getRegistry()->getModuleDescriptor()->getCmsAndPaysystemName('-'));
    }
}