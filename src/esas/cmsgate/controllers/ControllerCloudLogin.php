<?php


namespace esas\cmsgate\controllers;


use esas\cmsgate\CloudRegistry;
use esas\cmsgate\Registry;
use esas\cmsgate\view\client\CookieCloud;
use esas\cmsgate\view\client\RequestParamsCloud;
use Exception;
use Throwable;

class ControllerCloudLogin extends Controller
{
    public function process()
    {
        $login = $_POST[RequestParamsCloud::LOGIN_FORM_LOGIN];
        $password = $_POST[RequestParamsCloud::LOGIN_FORM_PASSWORD];
        $loggerMainString = "Login[" . $login . "]: ";
        $this->logger->info($loggerMainString . "Controller started");
        try {
            Registry::getRegistry()->getPaysystemConnector()->checkAuth($login, $password, CloudRegistry::getRegistry()->isSandbox());
            $hash = md5(self::generateCode(10));
            $authId = CloudRegistry::getRegistry()->getConfigCacheRepository()->addOrUpdateAuth($login, $password, $hash);
            setcookie(CookieCloud::ID, $authId, time() + 60 * 60 * 24 * 30, "/");
            setcookie(CookieCloud::HASH, $hash, time() + 60 * 60 * 24 * 30, "/", null, null, true); // httponly !!!
        } catch (Throwable $e) {
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
            throw $e;
        } catch (Exception $e) { // для совместимости с php 5
            $this->logger->error($loggerMainString . "Controller exception! ", $e);
            Registry::getRegistry()->getMessenger()->addErrorMessage($e->getMessage());
            throw $e;
        }
    }

    private static function generateCode($length = 6)
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