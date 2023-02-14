<?php


namespace esas\cmsgate\bridge;



abstract class ShopConfigBridgeRepository extends ShopConfigRepository
{
    /**
     * @param $login
     * @return string
     */
    public abstract function getSecretByLogin($login);

    public abstract function saveSecret($cacheConfigUUID, $secret);

    /**
     * @param $login
     * @return ShopConfig
     */
    public abstract function getByLogin($login);

    public abstract function addOrUpdateAuth($login, $password, $hash);

    public abstract function getAuthHashById($id);

}