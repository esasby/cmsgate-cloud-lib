<?php


namespace esas\cmsgate\security;


use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class CryptServiceImpl extends CryptService
{
    private $key;

    public function __construct()
    {
        if (file_exists($this->keyFileName())) {
            $keyStr = file_get_contents($this->keyFileName());
            $this->key = Key::loadFromAsciiSafeString($keyStr);
        } else {
            $this->key = Key::createNewRandomKey();
            file_put_contents($this->keyFileName(), $this->key->saveToAsciiSafeString());
        }
    }

    private function keyFileName() {
        return (dirname(__FILE__)) . '/key.bin';
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