<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 11:35
 */

namespace esas\cmsgate;


use esas\cmsgate\cache\OrderCacheRepository;
use esas\cmsgate\cache\OrderCacheService;
use esas\cmsgate\security\ApiAuthService;
use esas\cmsgate\security\CryptService;
use esas\cmsgate\security\CryptServiceImpl;
use esas\cmsgate\cache\ConfigCacheService;
use esas\cmsgate\cache\ConfigCacheRepository;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\Logger;
use esas\cmsgate\utils\SessionUtils;
use esas\cmsgate\view\admin\AdminConfigPage;
use esas\cmsgate\view\admin\AdminLoginPage;
use esas\cmsgate\view\admin\AdminViewFields;

abstract class CloudRegistry
{
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
     * @var ConfigCacheRepository
     */
    protected $configCacheRepository;

    /**
     * @var ConfigCacheService
     */
    protected $configCacheService;

    /**
     * @var ApiAuthService
     */
    protected $apiAuthService;

    /**
     * @var AdminLoginPage
     */
    protected $adminLoginPage;

    /**
     * @var AdminConfigPage
     */
    protected $adminConfigPage;

    public function init() {
        $registryName = self::getUniqRegistryName();
        global $$registryName;
        if ($$registryName == null) {
            $$registryName = $this;
        }
    }

    /**
     * В случае, если в CMS одновеременно установлено несколько cmsgate плагинов,
     * Registry каждого должны быть сохранен в global под разными именами
     * Для уникальности генерируем хэш по пути текущего файла
     * @return string
     */
    private static function getUniqRegistryName() {
        return "cmsCloudRegistry_" . hash('md5', __FILE__);
    }

    /**
     * @return CloudRegistry
     */
    public static function getRegistry() {
        /**
         * @var $esasRegistry
         */
        $registryName = self::getUniqRegistryName();
        global $$registryName;
        if ($$registryName == null) {
            Logger::getLogger("cloudRegistry")->fatal("CMSGate cloud registry is not initialized!");
        }
        return $$registryName;
    }

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
     * @return ConfigCacheRepository
     */
    public function getConfigCacheRepository() {
        if ($this->configCacheRepository == null)
            $this->configCacheRepository = $this->createConfigCacheRepository();
        return $this->configCacheRepository;
    }

    /**
     * @return ConfigCacheRepository
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
     * @return ConfigCacheService
     */
    public function getConfigCacheService() {
        if ($this->configCacheService == null)
            $this->configCacheService = $this->createConfigCacheService();
        return $this->configCacheService;
    }

    /**
     * @return ConfigCacheService
     * @throws CMSGateException
     */
    protected function createConfigCacheService() {
        return new ConfigCacheService();
    }

    /**
     * @return ApiAuthService
     */
    public function getApiAuthService() {
        if ($this->apiAuthService == null)
            $this->apiAuthService = $this->createApiAuthService();
        return $this->apiAuthService;
    }

    /**
     * @return ApiAuthService
     * @throws CMSGateException
     */
    protected abstract function createApiAuthService();

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


}