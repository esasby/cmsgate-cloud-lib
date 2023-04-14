<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\FormUtils;
use esas\cmsgate\utils\htmlbuilder\page\PageUtils;
use esas\cmsgate\utils\RequestUtils;
use esas\cmsgate\utils\SessionUtilsBridge;
use esas\cmsgate\view\admin\AdminBridgeShopConfigPage;
use Exception;
use Throwable;

class ControllerBridgeConfig extends Controller
{
    public function process() {
        BridgeConnector::fromRegistry()->getMerchantService()->checkAuth(true);
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