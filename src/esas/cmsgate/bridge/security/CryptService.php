<?php
namespace esas\cmsgate\bridge\security;

use esas\cmsgate\Registry;
use esas\cmsgate\service\Service;

abstract class CryptService extends Service
{
    /**
     * @inheritDoc
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(CryptService::class, new CryptServiceImpl());
    }

    public abstract function encrypt($data);

    public abstract function decrypt($data);

    public static function generateCode($length = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }
}