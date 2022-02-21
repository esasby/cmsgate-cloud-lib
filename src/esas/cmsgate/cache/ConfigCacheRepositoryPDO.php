<?php


namespace esas\cmsgate\cache;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\StringUtils;
use PDO;

class ConfigCacheRepositoryPDO extends ConfigCacheRepository
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
            $this->tableName = Registry::getRegistry()->getCmsConnector()->getCmsConnectorDescriptor()->getCmsMachineName()
                . Registry::getRegistry()->getPaySystemName()
                . '_order_cache';
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
            $secret = CloudRegistry::getRegistry()->getCryptService()->decrypt($row[self::COLUMN_SECRET]);
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
            $configCache =  $this->createConfigCacheObject($row);
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
                'password' => CloudRegistry::getRegistry()->getCryptService()->encrypt($password),
                'auth_hash' => $hash,
            ]);
            return $uuid;
        }
        $uuid = StringUtils::guidv4();
        $sql = "INSERT INTO $this->tableName (id, login, password, auth_hash, created_at, last_login_at ) VALUES (:id, :login, :password, :auth_hash, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $uuid,
            'login' => $login,
            'password' => CloudRegistry::getRegistry()->getCryptService()->encrypt($password),
            'auth_hash' => $hash,
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
            $authHash = CloudRegistry::getRegistry()->getCryptService()->decrypt($row[self::COLUMN_AUTH_HASH]);
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
            $configCache =  $this->createConfigCacheObject($row);
        }
        return $configCache;
    }

    private function createConfigCacheObject($row) {
        $configCache = new ConfigCache();
        $configCache->setConfigArray(json_decode(CloudRegistry::getRegistry()->getCryptService()->decrypt($row['config_data']), true));
        $configCache->setUuid($row[self::COLUMN_ID]);
        $configCache->setLogin($row[self::COLUMN_LOGIN]);
        $configCache->setSecret(CloudRegistry::getRegistry()->getCryptService()->decrypt($row[self::COLUMN_SECRET]));
        $configCache->setPassword(CloudRegistry::getRegistry()->getCryptService()->decrypt($row[self::COLUMN_PASSWORD]));
        return $configCache;
    }

}