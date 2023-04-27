<?php
namespace esas\cmsgate\bridge\service;

use esas\cmsgate\bridge\BridgeConnector;
use esas\cmsgate\service\RedirectService;

abstract class RedirectServiceBridge extends RedirectService
{
    const PATH_CONFIG = '/config';
    const PATH_ORDERS = '/orders';
    const PATH_CONFIG_SECRET_NEW = '/config/secret/new';
    const PATH_CONFIG_LOGIN = '/config/login';
    const PATH_CONFIG_LOGOUT = '/config/logout';
    /**
     * @return $this
     * @throws \esas\cmsgate\utils\CMSGateException
     */
    public static function fromRegistry() {
        return BridgeConnector::fromRegistry()->getMerchantService()->getRedirectService();
    }

    public abstract function loginPage($sendHeader = false);

    public abstract function logoutPage($sendHeader = false);

    public abstract function mainPage($sendHeader = false);
}