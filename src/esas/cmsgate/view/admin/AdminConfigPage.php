<?php


namespace esas\cmsgate\view\admin;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;
use esas\cmsgate\utils\htmlbuilder\presets\ScriptsPreset as script;
use esas\cmsgate\utils\htmlbuilder\presets\CssPreset as css;
use esas\cmsgate\utils\htmlbuilder\presets\CommonPreset as common;
use esas\cmsgate\utils\htmlbuilder\Page;
use esas\cmsgate\utils\RedirectUtilsBridge;
use esas\cmsgate\view\admin\fields\ConfigFieldText;

class AdminConfigPage extends Page
{

    public function elementPageHead()
    {
        return element::head(
            element::title(
                element::content($this->getPageTitle())
            ),
            $this->elementHeadMetaCharset('utf-8'),
            element::meta(
                attribute::name('viewport'),
                attribute::content('width=device-width, initial-scale=1, shrink-to-fit=no')),
            css::elementLinkCssGoogleFonts("css?family=Merienda+One"),
            css::elementLinkCssGoogleFonts("icon?family=Material+Icons"),
            css::elementLinkCssFontAwesome4Min(),
            css::elementLinkCssBootstrap4Min(),
            script::elementScriptJquery3Min(),
            script::elementScriptPopper1Min(),
            script::elementScriptBootstrap4Min(),
            element::styleFile(dirname(__FILE__) . "/config.css"),
            element::scriptFile(dirname(__FILE__) . "/copyToClipboard.js")
        );
    }

    public function getPageTitle()
    {
        return "Configuration";
    }

    public function elementPageBody()
    {
        return element::body(
            element::nav(
                attribute::clazz("navbar navbar-expand-md navbar-dark fixed-top bg-dark"),
                element::a(
                    attribute::clazz("navbar-brand"),
                    attribute::href('#'),
                    element::content(
                        Registry::getRegistry()->getModuleDescriptor()->getModuleFullName() . self::elementTestLabel())
                ),
                element::div(
                    attribute::clazz("collapse navbar-collapse"),
                    attribute::id("navbarCollapse"),
                    common::elementNavBarList(
                        common::elementNavBarListItem("#", "Configuration", true),
                        common::elementNavBarListItem("#", "Orders", false)
                    )
                ),
                element::a(
                    attribute::clazz("nav-link btn btn-outline-warning my-2 my-sm-0 btn-sm"),
                    attribute::href(RedirectUtilsBridge::logout()),
                    "Logout"
                )
            ),
            element::main(
                attribute::role("main"),
                attribute::clazz("container"),
                $this->elementSecret(),
                element::br(),
                $this->elementMessages(),
                $this->elementConfigForms(),
                element::br()
            ),
//            Registry::getRegistry()->getConfigForm()->generate()
        );
    }

    public function elementConfigForms()
    {
        $forms = "";
        foreach (Registry::getRegistry()->getConfigFormsArray() as $configForm) {
            $forms .= $configForm->generate();
        }
        return $forms;
    }

    protected function elementSecret()
    {
        $configField = new ConfigFieldText(
            AdminViewFieldsBridge::API_SECRET,
            'API Secret',
            '',
            false,
            null,
            true
        );
        $configField->setValue(BridgeConnector::fromRegistry()->getShopConfigService()->getSessionShopConfigSafe()->getCmsSecret());
        return
            element::div(
                attribute::clazz("form"),
                element::div(
                    attribute::clazz("card card-default"),
                    element::div(
                        attribute::clazz("card-body"),
                        ConfigFormBridge::elementFormGroup(
                            $configField,
                            ConfigFormBridge::elementInput($configField, "text"),
                            element::div(
                                attribute::clazz('btn-group col col-sm-2 pl-0'),
                                element::button(
                                    attribute::type("button"),
                                    attribute::role("group"),
                                    attribute::onclick("copyToClipboard('" . $configField->getKey() . "')"),
                                    attribute::clazz("btn btn-secondary"),
                                    "Copy"
                                ),
                                element::a(
                                    attribute::href(RedirectUtilsBridge::secretGenerate()),
                                    attribute::clazz("btn btn-secondary"),
                                    "Generate"
                                ),
                            )
                        )
                    )
                )
            );
    }

    public static function elementTestLabel()
    {
        return
            BridgeConnector::fromRegistry()->isSandbox() ? element::small(
                attribute::style('color: #EC9941!important; vertical-align: sub'),
                'test') : "";
    }
}