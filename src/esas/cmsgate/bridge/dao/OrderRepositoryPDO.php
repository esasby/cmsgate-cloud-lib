<?php
namespace esas\cmsgate\bridge\dao;

use esas\cmsgate\bridge\security\CryptService;
use esas\cmsgate\Registry;
use esas\cmsgate\service\PDOService;
use esas\cmsgate\utils\StringUtils;
use PDO;

/**
 * Class OrderRepositoryPDO
 * @package esas\cmsgate\bridge
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
class OrderRepositoryPDO extends OrderRepository
{
    /**
     * @var PDO
     */
    protected $pdo;

    protected $tableName;

    const COLUMN_ID = 'id';
    const COLUMN_CONFIG_ID = 'config_id';
    const COLUMN_EXT_ID = 'ext_id';
    const COLUMN_STATUS = 'status';
    const COLUMN_CREATED_AT = 'created_at';
    const COLUMN_ORDER_DATA = 'order_data';
    const COLUMN_ORDER_DATA_HASH = 'order_data_hash';

    public function __construct($tableName = null)
    {
        parent::__construct();
        $this->tableName = $tableName;
    }

    public function postConstruct() {
        $this->pdo = PDOService::fromRegistry()->getPDO(OrderRepository::class);
        if ($this->tableName == null)
            $this->tableName = Registry::getRegistry()->getModuleDescriptor()->getCmsAndPaysystemName()
                . '_order_cache';
    }

    /**
     * @param $order Order
     * @param $configId
     * @return string
     */
    public function add($order)
    {
        $uuid = StringUtils::guidv4();
        $sql = "INSERT INTO $this->tableName (id, config_id, created_at, order_data, order_data_hash, status) VALUES (:id, :config_id, CURRENT_TIMESTAMP, :order_data, :order_data_hash, 'new')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            self::COLUMN_ID => $uuid,
            self::COLUMN_CONFIG_ID => $order->getShopConfigId(),
            self::COLUMN_ORDER_DATA => $this->encodeOrderData($order->getOrderData()),
            self::COLUMN_ORDER_DATA_HASH => self::hashData($order->getOrderData()),
        ]);
        return $uuid;
    }

    protected function encodeOrderData($orderData) {
        $orderData = json_encode($orderData);
        return CryptService::fromRegistry()->encrypt($orderData);
    }

    protected function decodeOrderData($orderData) {
        $orderData = CryptService::fromRegistry()->decrypt($orderData);
        return json_decode($orderData, true);
    }

    protected static function hashData($data)
    {
        return hash('md5', $data);
    }

    public function getByID($orderId)
    {
        $sql = "select * from $this->tableName where id = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'uuid' => $orderId,
        ]);
        $cache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $cache = $this->createOrderObject($row);
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

    protected function createOrderObject($row)
    {
        $order = new Order();
        $order
            ->setId($row[self::COLUMN_ID])
            ->setShopConfigId($row[self::COLUMN_CONFIG_ID])
            ->setStatus($row[self::COLUMN_STATUS])
            ->setExtId($row[self::COLUMN_EXT_ID])
            ->setOrderData($this->decodeOrderData($row['order_data']))
            ->setCreatedAt($row[self::COLUMN_CREATED_AT]);
        return $order;
    }

    public function getByExtId($extId)
    {
        $sql = "select * from $this->tableName where ext_id = :extid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'extid' => $extId,
        ]);
        $cache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $cache = $this->createOrderObject($row);
        }
        return $cache;
    }

    public function getByData($orderData)
    {
        $orderData = json_encode($orderData);
        $sql = "select * from $this->tableName where order_data_hash = :order_data_hash";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'order_data_hash' => self::hashData($orderData),
        ]);
        $cache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $cache = $this->createOrderObject($row);
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

    public function getByShopConfigId($shopConfigId) {
        $sql = "select * from $this->tableName where config_id = :config_id order by created_at desc";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'config_id' => $shopConfigId,
        ]);
        $orders = array();
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $orders[] =  $this->createOrderObject($row);
        }
        return $orders;
    }
}