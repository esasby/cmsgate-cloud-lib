<?php


namespace esas\cmsgate\cache;


use esas\cmsgate\utils\Logger;

abstract class ConfigCacheRepository
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * OrderCacheRepository constructor.
     */
    public function __construct()
    {
        $this->logger = Logger::getLogger(get_class($this));

    }

    /**
     * @param $login
     * @return string
     */
    public abstract function getSecretByLogin($login);

    /**
     * @param $cacheConfigUUID
     * @return ConfigCache
     */
    public abstract function getByUUID($cacheConfigUUID);

    /**
     * @param $login
     * @return ConfigCache
     */
    public abstract function getByLogin($login);

    public abstract function addOrUpdateAuth($login, $password, $hash);

    public abstract function getAuthHashById($id);


}