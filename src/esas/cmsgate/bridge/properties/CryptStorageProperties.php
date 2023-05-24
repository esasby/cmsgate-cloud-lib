<?php


namespace esas\cmsgate\bridge\properties;


use esas\cmsgate\properties\Properties;

interface CryptStorageProperties extends Properties
{
    public function getStorageDir();
}