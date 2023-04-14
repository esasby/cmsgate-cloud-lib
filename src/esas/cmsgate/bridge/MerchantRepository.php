<?php


namespace esas\cmsgate\bridge;


use esas\cmsgate\bridge\Merchant;
use esas\cmsgate\utils\Logger;

abstract class MerchantRepository
{
    /**
     * @var Logger
     */
    protected $logger;

    public function __construct()
    {
        $this->logger = Logger::getLogger(get_class($this));

    }

    /**
     * @param $id string
     * @return Merchant
     */
    public abstract function getById($merchantId);

    public abstract function addOrUpdateAuth($login, $password, $hash);

    public abstract function getAuthHashById($id);
}