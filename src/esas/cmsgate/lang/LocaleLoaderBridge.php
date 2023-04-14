<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.09.2018
 * Time: 13:09
 */

namespace esas\cmsgate\lang;

abstract class LocaleLoaderBridge extends LocaleLoaderCms
{
    public function __construct()
    {
        $this->addExtraVocabularyDir(dirname(__FILE__));
    }
}