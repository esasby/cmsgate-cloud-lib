<?php


namespace esas\cmsgate\view\admin;


use esas\cmsgate\bridge\ShopConfigBridge;
use esas\cmsgate\BridgeConnector;
use esas\cmsgate\ConfigStorageCms;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;
use esas\cmsgate\utils\htmlbuilder\hro\HROFactoryCmsGate;
use esas\cmsgate\utils\htmlbuilder\page\StorableFormPage;
use esas\cmsgate\utils\htmlbuilder\presets\ScriptsPreset;
use esas\cmsgate\view\RedirectServiceBridge;

class AdminBridgeShopConfigPage extends AdminBridgePage implements StorableFormPage
{

    /**
     * @var ManagedFields
     */
    private $managedFields;

    public function __construct() {
        parent::__construct();
        $this->managedFields = Registry::getRegistry()->getConfigForm()->getManagedFields();
    }

    public function elementPageHead() {
        $head = parent::elementPageHead();
        $head->add(ScriptsPreset::elementScriptCopyToClipboard());
        return $head;
    }

    public function getNavItemId() {
        return RedirectServiceBridge::PATH_CONFIG;
    }

    public function elementPageContent() {
        return $this->elementSecretPanel() .
            element::br() .
            $this->elementConfigForms() .
            element::br();
    }

    public static function builder() {
        return new AdminBridgeShopConfigPage();
    }

    public function getFormFields() {
        return $this->managedFields;
    }

    public function elementConfigForms() {
        $form = HROFactoryCmsGate::fromRegistry()->createFormBuilder()
            ->setId(AdminViewFieldsBridge::SHOP_CONFIG_EDIT_FORM)
            ->setAction(RedirectServiceBridge::fromRegistry()->shopConfig())
            ->setManagedFields($this->managedFields)
            ->addButtonSave();
        return $form->build();
    }

    protected function elementSecretPanel() {
        return HROFactoryCmsGate::fromRegistry()->createCopyToClipboardPanel()
            ->setLabelId(AdminViewFieldsBridge::API_SECRET)
            ->setValue(BridgeConnector::fromRegistry()->getShopConfigService()->getSessionShopConfigSafe()->getCmsSecret())
            ->addButton(element::a(
                attribute::href(BridgeConnector::fromRegistry()->getMerchantService()->getRedirectService()->secretGenerate()),
                attribute::clazz("btn btn-secondary"),
                "Generate"))
            ->build();
    }

    public function getStorage() {
        Registry::getRegistry()->getConfigStorage();
    }
}