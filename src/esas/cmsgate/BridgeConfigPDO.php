<?php


namespace esas\cmsgate;


interface BridgeConfigPDO
{
    public function getPDO_DSN();

    public function getPDOUsername();

    public function getPDOPassword();
}