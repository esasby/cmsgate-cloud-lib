<?php

namespace esas\cmsgate\cache;

use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\StringUtils;
use PDO;

/**
 * Class OrderCacheRepositoryPDO
 * @package esas\cmsgate\cache
 * create table *_cache
 * (
 * id              varchar(36)  not null,
 * created_at      timestamp    null,
 * order_data      text         null,
 * order_data_hash char(32)     null,
 * ext_id          varchar(255) null,
 * status          varchar(30)  null,
 * constraint cache_ext_id_uindex
 * unique (ext_id),
 * constraint cache_id_uindex
 * unique (id)
 * );
 */
class OrderCacheRepositoryPDO extends OrderCacheRepository
{
    /**
     * @var PDO
     */
    protected $pdo;

    protected $tableName;

//    public function __construct($dsn, $user, $pass, $tableName)
//    {
//        parent::__construct();
//        $opt = [
//            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//            PDO::ATTR_EMULATE_PREPARES => false,
//        ];
//        $this->pdo = new PDO($dsn, $user, $pass, $opt);
//        $this->tableName = $tableName;
//    }

    public function __construct($pdo, $tableName = null)
    {
        parent::__construct();
        $this->pdo = $pdo;
        if ($tableName != null)
            $this->tableName = $tableName;
        else
            $this->tableName = Registry::getRegistry()->getModuleDescriptor()->getCmsAndPaysystemName()
                . '_order_cache';
    }

    /**
     * @param $orderData OrderCache
     */
    public function add($orderData)
    {
        $uuid = StringUtils::guidv4();
        $orderData = json_encode($orderData);
        $sql = "INSERT INTO $this->tableName (id, created_at, order_data, order_data_hash, status) VALUES (:uuid, CURRENT_TIMESTAMP,  :order_data, :order_data_hash, 'new')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'uuid' => $uuid,
            'order_data' => CloudRegistry::getRegistry()->getCryptService()->encrypt($orderData),
            'order_data_hash' => self::hashData($orderData),
        ]);
        return $uuid;
    }

    private static function hashData($data)
    {
        return hash('md5', $data);
    }

    public function getByUUID($cacheUUID)
    {
        $sql = "select id, order_data, ext_id, status from $this->tableName where id = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'uuid' => $cacheUUID,
        ]);
        $cache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $cache = $this->createOrderCacheObject($row);
        }
        return $cache;
    }

    public function saveExtId($cacheUUID, $extId)
    {
        $sql = "update $this->tableName set ext_id = :ext_id where id = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'uuid' => $cacheUUID,
            'ext_id' => $extId,
        ]);
    }

    private function createOrderCacheObject($row)
    {
        $orderData = CloudRegistry::getRegistry()->getCryptService()->decrypt($row['order_data']);
        return new OrderCache($row['id'], json_decode($orderData, true), $row['ext_id'], $row['status']);
    }

    public function getByExtId($extId)
    {
        $sql = "select id, order_data, ext_id, status from $this->tableName where ext_id = :extid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'extid' => $extId,
        ]);
        $cache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $cache = $this->createOrderCacheObject($row);
        }
        return $cache;
    }

    public function getByData($orderData)
    {
        $orderData = json_encode($orderData);
        $sql = "select id, order_data, ext_id, status from $this->tableName where order_data_hash = :order_data_hash";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'order_data_hash' => self::hashData($orderData),
        ]);
        $cache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $cache = $this->createOrderCacheObject($row);
        }
        return $cache;
    }

    public function setStatus($cacheUUID, $status)
    {
        $sql = "update $this->tableName set status = :status where id = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'uuid' => $cacheUUID,
            'status' => $status,
        ]);
    }
}