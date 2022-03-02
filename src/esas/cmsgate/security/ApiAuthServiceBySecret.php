<?php


namespace esas\cmsgate\security;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\utils\CMSGateException;

abstract class ApiAuthServiceBySecret extends ApiAuthService
{
    private $requestFieldSignature;

    /**
     * ConfigCacheService constructor.
     * @param $requestFieldSignature
     */
    public function __construct($requestFieldSignature)
    {
        parent::__construct();
        $this->requestFieldSignature = $requestFieldSignature;
    }

    public function checkAuth(&$request)
    {
        $login = $request[CloudRegistry::getRegistry()->getAuthConfigMapper()->getConfigFieldLogin()];
        $secret = CloudRegistry::getRegistry()->getConfigCacheRepository()->getSecretByLogin($login);
        $signature = $this->generateVerificationSignature($request, $secret);
        if ($signature !== $request[$this->requestFieldSignature])
            throw new CMSGateException('Signature is incorrect');
        $configCache = CloudRegistry::getRegistry()->getConfigCacheRepository()->getByLogin($login);
        return $configCache;
    }

    public abstract function generateVerificationSignature($request, $secret);
}