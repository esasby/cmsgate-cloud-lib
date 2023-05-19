<?php


namespace esas\cmsgate\bridge\properties;


use esas\cmsgate\bridge\properties\RecaptchaProperties;
use esas\cmsgate\properties\LocaleProperties;
use esas\cmsgate\properties\PDOConnectionProperties;
use esas\cmsgate\properties\SandboxProperties;
use esas\cmsgate\properties\ViewProperties;
use esas\cmsgate\Registry;

abstract class PropertiesBridge implements
    PDOConnectionProperties,
    SandboxProperties
{
    /**
     * Для удобства работы в IDE и подсветки синтаксиса.
     * @return $this
     */
    public static function fromRegistry()
    {
        return Registry::getRegistry()->getProperties();
    }
}