<?php


namespace esas\cmsgate\bridge\service;


interface RedirectServiceMerchant
{
    public function loginPage($sendHeader = false);

    public function logoutPage($sendHeader = false);

    public function mainPage($sendHeader = false);
}