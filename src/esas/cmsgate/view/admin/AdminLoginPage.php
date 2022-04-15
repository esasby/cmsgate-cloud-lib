<?php


namespace esas\cmsgate\view\admin;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;
use esas\cmsgate\utils\htmlbuilder\Page;
use esas\cmsgate\utils\htmlbuilder\presets\CssPreset as css;
use esas\cmsgate\utils\htmlbuilder\presets\ScriptsPreset as script;
use esas\cmsgate\view\client\RequestParamsCloud;

class AdminLoginPage extends Page
{
    private $loginFormAction;

    /**
     * AdminLoginPage constructor.
     * @param $loginFormAction
     */
    public function __construct($loginFormAction = null)
    {
        parent::__construct();
        $this->loginFormAction = $loginFormAction;
    }


    public function elementPageHead()
    {
        return element::head(
            element::title(
                element::content($this->getPageTitle())
            ),
            $this->elementHeadMetaCharset('utf-8'),
            element::meta(
                attribute::name('viewport'),
                attribute::content('width=device-width, shrink-to-fit=no, initial-scale=1')),
            css::elementLinkCssGoogleFonts("css?family=Merienda+One"),
            css::elementLinkCssGoogleFonts("icon?family=Material+Icons"),
            css::elementLinkCssFontAwesome4Min(),
            css::elementLinkCssBootstrap4Min(),
            script::elementScriptJquery3Min(),
            script::elementScriptBootstrap4Min(),
            script::elementScriptPopper1Min(),
            element::styleFile(dirname(__FILE__) . "/login.css")
        );
    }

    public function getPageTitle()
    {
        return "Login";
    }

    public function elementPageBody()
    {
        return element::body(
            element::div(
                attribute::clazz("login-form"),
                element::form(
                    $this->attributeLoginFormAction(),
                    attribute::method("post"),
                    element::div(
                        attribute::clazz("avatar"),
                        element::i(
                            attribute::clazz("material-icons"),
                            "&#xE7FF;"
                        )
                    ),
                    element::h4(
                        attribute::clazz("modal-title"),
                        "Login to " . Registry::getRegistry()->getPaysystemConnector()->getPaySystemConnectorDescriptor()->getPaySystemMachinaName() . AdminConfigPage::elementTestLabel()
                    ),
                    $this->elementLoginInput(),
                    $this->elementPasswordInput(),
                    $this->elementMessages(),
                    $this->elementSubmitButton()
                )
            )
        );
    }

    public function attributeLoginFormAction()
    {
        return $this->loginFormAction != null ? attribute::action($this->loginFormAction) : "";
    }

    public function elementLoginInput()
    {
        return
            element::div(
                attribute::clazz("form-group"),
                element::input(
                    attribute::id(RequestParamsCloud::LOGIN_FORM_LOGIN),
                    attribute::name(RequestParamsCloud::LOGIN_FORM_LOGIN),
                    attribute::clazz("form-control"),
                    attribute::type("text"),
                    attribute::placeholder("Username"),
                    attribute::required()
                )
            );
    }

    public function elementPasswordInput()
    {
        return
            element::div(
                attribute::clazz("form-group"),
                element::input(
                    attribute::id(RequestParamsCloud::LOGIN_FORM_PASSWORD),
                    attribute::name(RequestParamsCloud::LOGIN_FORM_PASSWORD),
                    attribute::clazz("form-control"),
                    attribute::type("password"),
                    attribute::placeholder("Password"),
                    attribute::required()
                )
            );
    }

    public function elementSubmitButton()
    {
        return
            element::input(
                attribute::type("submit"),
                attribute::clazz("btn btn-primary btn-block btn-lg"),
                attribute::value("Login")
            );
    }
}