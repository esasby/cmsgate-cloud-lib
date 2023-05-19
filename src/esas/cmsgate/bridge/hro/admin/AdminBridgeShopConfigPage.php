<?php


namespace esas\cmsgate\bridge\hro\admin;


use esas\cmsgate\bridge\service\RedirectServiceBridge;
use esas\cmsgate\bridge\service\ShopConfigService;
use esas\cmsgate\bridge\view\admin\AdminViewFieldsBridge;
use esas\cmsgate\hro\forms\FormHROFactory;
use esas\cmsgate\hro\panels\CopyToClipboardPanelHROFactory;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;
use esas\cmsgate\utils\htmlbuilder\page\StorableFormPage;
use esas\cmsgate\utils\htmlbuilder\presets\ScriptsPreset;
use esas\cmsgate\view\admin\ManagedFields;

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
        $form = FormHROFactory::findBuilder()
            ->setId(AdminViewFieldsBridge::SHOP_CONFIG_EDIT_FORM)
            ->setAction(RedirectServiceBridge::fromRegistry()->shopConfig())
            ->setManagedFields($this->managedFields)
            ->addButtonSave();
        return $form->build();
    }

    protected function elementSecretPanel() {
        return CopyToClipboardPanelHROFactory::findBuilder()
            ->setLabelId(AdminViewFieldsBridge::API_SECRET)
            ->setValue(ShopConfigService::fromRegistry()->getSessionShopConfigSafe()->getCmsSecret())
            ->addButton(element::a(
                attribute::href(RedirectServiceBridge::fromRegistry()->secretGenerate()),
                attribute::clazz("btn btn-secondary"),
                "Generate"))
            ->build();
    }

    public function getStorage() {
        Registry::getRegistry()->getConfigStorage();
    }
}