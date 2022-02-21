<?php


namespace esas\cmsgate\view\admin;


use esas\cmsgate\hutkigrosh\wrappers\ConfigWrapperHutkigrosh;
use esas\cmsgate\lang\Translator;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;
use esas\cmsgate\utils\htmlbuilder\Page;
use esas\cmsgate\utils\Logger;
use esas\cmsgate\wrappers\OrderWrapper;

class AdminLoginPage extends Page
{
    private $loginFormAction;

    /**
     * AdminLoginPage constructor.
     * @param $loginFormAction
     */
    public function __construct($loginFormAction)
    {
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
                attribute::content('width=device-width, initial-scale=1')),
            $this->elementHeadLinkStylesheet("https://fonts.googleapis.com/css?family=Merienda+One"),
            $this->elementHeadLinkStylesheet("https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"),
            $this->elementHeadLinkStylesheet("https://fonts.googleapis.com/icon?family=Material+Icons"),
            $this->elementHeadLinkStylesheet("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"),
            $this->elementHeadScript("https://code.jquery.com/jquery-3.5.1.min.js"),
            $this->elementHeadScript("https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"),
            $this->elementHeadScript("https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"),
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
                    attribute::action($this->getLoginFormAction()),
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
                        "Login to Your Account"
                    ),
                    $this->elementLoginInput(),
                    $this->elementPasswordInput(),
                )
            )
        );
    }

    public function getLoginFormAction() {
        return $this->loginFormAction;
    }

    public function elementLoginInput()
    {
        return
            element::div(
                attribute::clazz("form-group"),
                element::input(
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
                    attribute::clazz("form-control"),
                    attribute::type("password"),
                    attribute::placeholder("Password"),
                    attribute::required()
                )
            );
    }
}