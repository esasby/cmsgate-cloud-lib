<?php
namespace esas\cmsgate\bridge\security;

use esas\cmsgate\bridge\dao\ShopConfig;
use esas\cmsgate\service\Service;

abstract class CmsAuthService extends Service
{
    /**
     * @param $request
     * @return ShopConfig
     */
    public abstract function checkAuth(&$request);
}