<?php
namespace esas\cmsgate\bridge\security;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\CMSGateException;

class CryptServiceImpl extends CryptService
{
    private $keyDir;
    private $key;

    public function __construct($keyDir = null)
    {
        if ($keyDir == null)
            $keyDir = (dirname(__FILE__));
        $this->keyDir = $keyDir;
        if (file_exists($this->keyFileName())) {
            $keyStr = file_get_contents($this->keyFileName());
            $this->key = Key::loadFromAsciiSafeString($keyStr);
        } else {
            $this->key = Key::createNewRandomKey();
            if (!file_put_contents($this->keyFileName(), $this->key->saveToAsciiSafeString()))
                throw new CMSGateException('Can not create key file', 'Incorrect config. Please connect to service support');
        }
    }

    private function keyFileName() {
        return $this->keyDir . '/' . Registry::getRegistry()->getPaySystemName() . '-key.bin';
    }

    public function encrypt($data)
    {
        return Crypto::encrypt($data, $this->key);
    }

    public function decrypt($data)
    {
        return Crypto::decrypt($data, $this->key);
    }

}