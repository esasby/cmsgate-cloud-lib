<?php


namespace esas\cmsgate\bridge\service;


use esas\cmsgate\bridge\properties\RecaptchaProperties;
use esas\cmsgate\Registry;
use esas\cmsgate\service\Service;
use esas\cmsgate\utils\CMSGateException;
use ReCaptcha\ReCaptcha;

class RecaptchaService extends Service
{
    /**
     * @return $this
     */
    public static function fromRegistry() {
        return Registry::getRegistry()->getService(RecaptchaService::class, new RecaptchaService());
    }

    public function validateRequest() {
        /** @var RecaptchaProperties $properties */
        $properties = Registry::getRegistry()->getProperties();
        if (isset($_POST['g-recaptcha-response'])) {
            // создать экземпляр службы recaptcha, используя секретный ключ
            $recaptcha = new ReCaptcha($properties->getRecaptchaSecretKey());
            // получить результат проверки кода recaptcha
            $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            // если результат положительный, то...
            if ($resp->isSuccess()){
                return;
            } else {
                // иначе передать ошибку
                $errors = $resp->getErrorCodes();
                throw new CMSGateException('Incorrect recaptcha', 'Incorrect recaptcha. Please try later');
            }

        } else {
            //ошибка, не существует ассоциативный массив $_POST["send-message"]
            throw new CMSGateException('Recaptcha is not present in request', 'Incorrect recaptcha. Please try later');
        }
    }
}