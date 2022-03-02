<?php


namespace esas\cmsgate\security;


class AuthConfigMapper
{
    private $configFieldLogin;
    private $configFieldPassword;

    /**
     * ConfigCacheService constructor.
     * @param $configFieldLogin
     * @param $configFieldPassword
     * @param $requestFieldSignature
     */
    public function __construct($configFieldLogin, $configFieldPassword)
    {
        $this->configFieldLogin = $configFieldLogin;
        $this->configFieldPassword = $configFieldPassword;
    }

    /**
     * @return mixed
     */
    public function getConfigFieldLogin()
    {
        return $this->configFieldLogin;
    }

    /**
     * @return mixed
     */
    public function getConfigFieldPassword()
    {
        return $this->configFieldPassword;
    }
}