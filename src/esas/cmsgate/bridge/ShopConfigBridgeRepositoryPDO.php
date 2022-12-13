<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\BridgeConnector;
use esas\cmsgate\Registry;
use esas\cmsgate\security\CryptService;
use esas\cmsgate\utils\StringUtils;
use Exception;
use PDO;
use Throwable;

class ShopConfigBridgeRepositoryPDO extends ShopConfigBridgeRepository
{
    /**
     * @var PDO
     */
    protected $pdo;
    protected $tableName;

    const COLUMN_ID = 'id';
    const COLUMN_LOGIN = 'login';
    const COLUMN_PASSWORD = 'password';
    const COLUMN_AUTH_HASH = 'auth_hash';
    const COLUMN_SECRET = 'secret';
    const COLUMN_CONFIG_DATA = 'config_data';

    public function __construct($pdo, $tableName = null)
    {
        parent::__construct();
        $this->pdo = $pdo;
        if ($tableName != null)
            $this->tableName = $tableName;
        else
            $this->tableName = Registry::getRegistry()->getModuleDescriptor()->getCmsAndPaysystemName()
                . '_config_cache';
    }

    public function getSecretByLogin($login)
    {
        $sql = "select * from $this->tableName where login = :login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'login' => $login,
        ]);
        $secret = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $secret = BridgeConnector::fromRegistry()->getCryptService()->decrypt($row[self::COLUMN_SECRET]);
        }
        return $secret;
    }

    public function getByLogin($login)
    {
        $sql = "select * from $this->tableName where login = :login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'login' => $login,
        ]);
        $configCache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $configCache =  $this->createShopConfigObject($row);
        }
        return $configCache;
    }

    public function addOrUpdateAuth($login, $password, $hash)
    {
        $sql = "select * from $this->tableName where login = :login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'login' => $login,
        ]);
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $uuid = $row[self::COLUMN_ID];
            $sql = "UPDATE $this->tableName set password = :password, auth_hash = :auth_hash , last_login_at = CURRENT_TIMESTAMP where id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id' => $uuid,
                'password' => BridgeConnector::fromRegistry()->getCryptService()->encrypt($password),
                'auth_hash' => $hash,
            ]);
            return $uuid;
        }
        $uuid = StringUtils::guidv4();
        $sql = "INSERT INTO $this->tableName (id, login, password, auth_hash, created_at, last_login_at, secret ) VALUES (:id, :login, :password, :auth_hash, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :secret)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $uuid,
            'login' => $login,
            'password' => BridgeConnector::fromRegistry()->getCryptService()->encrypt($password),
            'auth_hash' => $hash,
            'secret' => BridgeConnector::fromRegistry()->getCryptService()->encrypt(CryptService::generateCode(8)),
        ]);
        return $uuid;
    }

    public function getAuthHashById($id)
    {
        $sql = "select * from $this->tableName where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
        ]);
        $authHash = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $authHash = $row[self::COLUMN_AUTH_HASH];
        }
        return $authHash;
    }

    public function getByUUID($cacheConfigUUID)
    {
        $sql = "select * from $this->tableName where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $cacheConfigUUID,
        ]);
        $configCache = null;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            $configCache =  $this->createShopConfigObject($row);
        }
        return $configCache;
    }

    private function createShopConfigObject($row) {
        $configCache = new ShopConfigBridge();
        try {
            $configCache->setConfigArray(json_decode(BridgeConnector::fromRegistry()->getCryptService()->decrypt($row[self::COLUMN_CONFIG_DATA]), true));
        } catch (Throwable $e) {
            $configCache->setConfigArray(array()); // new config
        } catch (Exception $e) {
            $configCache->setConfigArray(array()); // new config
        }
        $configCache->setUuid($row[self::COLUMN_ID]);
        $configCache->setPaysystemLogin($row[self::COLUMN_LOGIN]);
        $configCache->setCmsSecret(BridgeConnector::fromRegistry()->getCryptService()->decrypt($row[self::COLUMN_SECRET]));
        $configCache->setPaysystemPassword(BridgeConnector::fromRegistry()->getCryptService()->decrypt($row[self::COLUMN_PASSWORD]));
        return $configCache;
    }

    public function saveConfigData($configCacheUUID, $configData)
    {
        $configData = json_encode($configData);
        $sql = "UPDATE $this->tableName set config_data = :config_data where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $configCacheUUID,
            self::COLUMN_CONFIG_DATA => BridgeConnector::fromRegistry()->getCryptService()->encrypt($configData)
        ]);
    }

    public function saveSecret($cacheConfigUUID, $secret)
    {
        $sql = "UPDATE $this->tableName set secret = :secret where id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $cacheConfigUUID,
            'secret' => BridgeConnector::fromRegistry()->getCryptService()->encrypt($secret),
        ]);
    }
}