<?php


namespace esas\cmsgate\security;


abstract class CryptService
{
    public abstract function encrypt($data);

    public abstract function decrypt($data);
}