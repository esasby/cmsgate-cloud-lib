<?php


namespace esas\cmsgate\view\admin;


use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;
use esas\cmsgate\utils\htmlbuilder\Page;

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
                attribute::content('width=device-width, initial-scale=1')),
            $this->elementHeadLinkStylesheet("https://fonts.googleapis.com/css?family=Merienda+One"),
            $this->elementHeadLinkStylesheet("https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"),
            $this->elementHeadLinkStylesheet("https://fonts.googleapis.com/icon?family=Material+Icons"),
            $this->elementHeadLinkStylesheet("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"),
            $this->elementHeadScript("https://code.jquery.com/jquery-3.5.1.min.js"),
            $this->elementHeadScript("https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"),
            $this->elementHeadScript("https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js")
        );
    }

    public function getPageTitle()
    {
        return "Configuration";
    }

    public function elementPageBody()
    {
        return element::body(
            Registry::getRegistry()->getConfigForm()->generate()
        );
    }
}