<?php


namespace esas\cmsgate\bridge\properties;


use esas\cmsgate\properties\PDOConnectionProperties;
use esas\cmsgate\properties\SandboxProperties;
use esas\cmsgate\Registry;

abstract class PropertiesBridge implements
    PDOConnectionProperties,
    SandboxProperties,
    CryptStorageProperties
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