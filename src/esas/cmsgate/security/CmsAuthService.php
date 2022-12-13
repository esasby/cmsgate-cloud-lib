<?php


namespace esas\cmsgate\security;


use esas\cmsgate\bridge\ShopConfig;
use esas\cmsgate\service\Service;

abstract class CmsAuthService extends Service
{
    /**
     * @param $request
     * @return ShopConfig
     */
    public abstract function checkAuth(&$request);
}