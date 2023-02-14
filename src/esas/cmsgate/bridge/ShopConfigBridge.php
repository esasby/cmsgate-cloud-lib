<?php


namespace esas\cmsgate\bridge;



class ShopConfigBridge extends ShopConfig
{
    private $cmsSecret;
    private $paysystemLogin;
    private $paysystemPassword;

    /**
     * @return mixed
     */
    public function getCmsSecret()
    {
        return $this->cmsSecret;
    }

    /**
     * @param mixed $cmsSecret
     */
    public function setCmsSecret($cmsSecret)
    {
        $this->cmsSecret = $cmsSecret;
    }

    /**
     * @return mixed
     */
    public function getPaysystemLogin()
    {
        return $this->paysystemLogin;
    }

    /**
     * @param mixed $paysystemLogin
     * @return ShopConfigBridge
     */
    public function setPaysystemLogin($paysystemLogin)
    {
        $this->paysystemLogin = $paysystemLogin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaysystemPassword()
    {
        return $this->paysystemPassword;
    }

    /**
     * @param mixed $paysystemPassword
     * @return ShopConfigBridge
     */
    public function setPaysystemPassword($paysystemPassword)
    {
        $this->paysystemPassword = $paysystemPassword;
        return $this;
    }
}