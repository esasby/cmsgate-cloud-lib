<?php


namespace esas\cmsgate\security;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\utils\CMSGateException;
use esas\cmsgate\utils\Logger;

abstract class ApiAuthServiceBySecret extends ApiAuthService
{
    private $configFieldLogin;
    private $configFieldPassword;
    private $requestFieldSignature;

    /**
     * ConfigCacheService constructor.
     * @param $configFieldLogin
     * @param $configFieldPassword
     * @param $requestFieldSignature
     */
    public function __construct($configFieldLogin, $configFieldPassword, $requestFieldSignature)
    {
        parent::__construct();
        $this->configFieldLogin = $configFieldLogin;
        $this->configFieldPassword = $configFieldPassword;
        $this->requestFieldSignature = $requestFieldSignature;
    }

    public function checkAuth(&$request)
    {
        $login = $request($this->configFieldLogin);
        $secret = CloudRegistry::getRegistry()->getConfigCacheRepository()->getSecretByLogin($login);
        $signature = $this->generateVerificationSignature($request, $secret);
        if ($signature !== $request[$this->requestFieldSignature])
            throw new CMSGateException('Signature is incorrect');
        $configCache = CloudRegistry::getRegistry()->getConfigCacheRepository()->getByLogin($login);
        $configCache->getConfigArray()[$this->configFieldPassword] = $configCache->getPassword(); // перекладываем пароль для более просто логики в ConfigStorage
        return $configCache;
    }

    public abstract function generateVerificationSignature($request, $secret);
}