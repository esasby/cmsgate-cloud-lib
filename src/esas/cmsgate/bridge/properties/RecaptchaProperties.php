<?php


namespace esas\cmsgate\bridge\properties;

use esas\cmsgate\properties\Properties;

interface RecaptchaProperties extends Properties
{
    public function getRecaptchaPublicKey();

    public function getRecaptchaSecretKey();
}