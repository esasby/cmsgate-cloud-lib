<?php
namespace esas\cmsgate\bridge\security;

use esas\cmsgate\bridge\dao\ShopConfig;
use esas\cmsgate\Registry;
use esas\cmsgate\service\Service;

abstract class CmsAuthService extends Service
{
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(CmsAuthService::class);
    }

    /**
     * @param $request
     * @return ShopConfig
     */
    public abstract function checkAuth(&$request);
}