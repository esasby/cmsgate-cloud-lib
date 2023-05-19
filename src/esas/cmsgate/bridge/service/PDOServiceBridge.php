<?php


namespace esas\cmsgate\bridge\service;


use esas\cmsgate\bridge\properties\PropertiesBridge;
use esas\cmsgate\service\PDOService;
use PDO;

class PDOServiceBridge extends PDOService
{
    public function getPDO($repositoryClass = null) {
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        return new PDO(
            PropertiesBridge::fromRegistry()->getPDO_DSN(),
            PropertiesBridge::fromRegistry()->getPDOUsername(),
            PropertiesBridge::fromRegistry()->getPDOPassword(),
            $opt);
    }
}