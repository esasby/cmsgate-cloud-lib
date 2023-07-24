<?php
namespace esas\cmsgate\bridge\security;

use esas\cmsgate\bridge\dao\ShopConfigBridgeRepository;
use esas\cmsgate\bridge\dao\ShopConfigRepository;
use esas\cmsgate\utils\CMSGateException;

abstract class CmsAuthServiceBySecret extends CmsAuthService
{

    public function checkAuth(&$request)
    {
        $login = $request[$this->getRequestFieldLogin()];

        /** @var ShopConfigBridgeRepository $shopConfigRepository */
        $shopConfigRepository = ShopConfigRepository::fromRegistry();
        $secret = $shopConfigRepository->getSecretByLogin($login);
        $signature = $this->generateVerificationSignature($request, $secret);
        if ($signature !== $request[$this->getRequestFieldSignature()])
            throw new CMSGateException('Signature is incorrect');
        $shopConfig = ShopConfigRepository::fromRegistry()->getByLogin($login);
        return $shopConfig;
    }

    public abstract function getRequestFieldLogin();

    public abstract function getRequestFieldSignature();

    public abstract function generateVerificationSignature($request, $secret);
}