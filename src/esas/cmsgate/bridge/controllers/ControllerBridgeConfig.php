<?php
namespace esas\cmsgate\bridge\controllers;

use esas\cmsgate\bridge\hro\admin\AdminBridgeShopConfigPage;
use esas\cmsgate\bridge\service\MerchantService;
use esas\cmsgate\controllers\Controller;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\page\PageUtils;
use esas\cmsgate\utils\RequestUtils;
use Exception;
use Throwable;

class ControllerBridgeConfig extends Controller
{
    public function process() {
        MerchantService::fromRegistry()->checkAuth(true);
        $shopConfigViewPage = new AdminBridgeShopConfigPage();
        try {
            if (RequestUtils::isMethodPost()) {
                PageUtils::validateFormInputAndRenderOnError($shopConfigViewPage);
                PageUtils::storeFormData($shopConfigViewPage);
            }
        } catch (Throwable $e) {
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        } catch (Exception $e) { // для совместимости с php 5
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
        }
        $shopConfigViewPage->render();
    }
}