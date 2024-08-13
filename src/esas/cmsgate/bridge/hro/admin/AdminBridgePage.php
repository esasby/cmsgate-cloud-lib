<?php


namespace esas\cmsgate\bridge\hro\admin;

use esas\cmsgate\bridge\properties\PropertiesBridge;
use esas\cmsgate\bridge\service\RedirectServiceBridge;
use esas\cmsgate\hro\pages\PageHRO;
use esas\cmsgate\lang\Translator;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;
use esas\cmsgate\utils\htmlbuilder\page\DisplayErrorPage;
use esas\cmsgate\utils\htmlbuilder\presets\BootstrapPreset as bootstrap;
use esas\cmsgate\utils\htmlbuilder\presets\CssPreset as css;
use esas\cmsgate\utils\htmlbuilder\presets\ScriptsPreset as script;
use esas\cmsgate\view\admin\AdminViewFields;

abstract class AdminBridgePage extends PageHRO implements DisplayErrorPage
{
    public function elementPageHead() {
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
            css::elementLinkCssBootstrapMin(),
            script::elementScriptJquery3Min(),
            script::elementScriptPopper1Min(),
            script::elementScriptBootstrapMin(),
            element::styleFile(dirname(__FILE__) . "/config.css")
        );
    }

    public function getPageTitle() {
        return "Cms bridge";
    }

    public function elementPageBody() {
        return element::body(
            element::nav(
                attribute::clazz("navbar navbar-expand-md navbar-dark fixed-top bg-dark"),
                element::div(
                    attribute::clazz("container-fluid"),
                    element::a(
                        attribute::clazz("navbar-brand"),
                        attribute::href('#'),
                        element::content(
                            Registry::getRegistry()->getModuleDescriptor()->getModuleFullName() . self::elementTestLabel())
                    ),
                    element::div(
                        attribute::clazz("collapse navbar-collapse"),
                        attribute::id("navbarCollapse"),
                        bootstrap::elementNavBarList(
                            bootstrap::elementNavBarListItem("#", "Configuration", $this->getNavItemId() == RedirectServiceBridge::PATH_CONFIG)
                        )
                    ),
                    element::a(
                        attribute::clazz("btn btn-outline-warning my-2 my-sm-0 btn-md"),
                        attribute::href(RedirectServiceBridge::fromRegistry()->logoutPage()),
                        Translator::fromRegistry()->translate(AdminViewFields::LOGOUT)
                    )
                )
            ),
            element::main(
                attribute::role("main"),
                attribute::clazz("container"),
                element::br(),
                $this->elementMessageAndContent()
            )
        );
    }

    public function elementMessageAndContent() {
        $messages = $this->elementMessages();
        return ($messages != '' ? $messages . element::br() : "")
            . ($this->isErrorPage() ? "" : $this->elementPageContent());
    }

    public abstract function getNavItemId();

    public abstract function elementPageContent();

    public static function elementTestLabel() {
        return
            PropertiesBridge::fromRegistry()->isSandbox() ? element::small(
                attribute::style('color: #EC9941!important; vertical-align: sub'),
                'test') : "";
    }

    public function isErrorPage() {
        return Registry::getRegistry()->getMessenger()->hasErrorMessages();
    }
}