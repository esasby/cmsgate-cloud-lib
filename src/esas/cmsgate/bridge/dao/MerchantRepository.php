<?php
namespace esas\cmsgate\bridge\dao;

use esas\cmsgate\dao\Repository;
use esas\cmsgate\Registry;

abstract class MerchantRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(MerchantRepository::class);
    }
    /**
     * @param $id string
     * @return Merchant
     */
    public abstract function getById($merchantId);

    public abstract function addOrUpdateAuth($login, $password, $hash);

    public abstract function getAuthHashById($id);
}