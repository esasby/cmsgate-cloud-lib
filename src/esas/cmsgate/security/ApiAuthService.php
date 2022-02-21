<?php


namespace esas\cmsgate\security;


use esas\cmsgate\cache\ConfigCache;
use esas\cmsgate\service\Service;

abstract class ApiAuthService extends Service
{
    /**
     * @param $request
     * @return ConfigCache
     */
    public abstract function checkAuth(&$request);
}