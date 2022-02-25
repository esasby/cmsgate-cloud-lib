<?php


namespace esas\cmsgate;

if (!class_exists("esas\cmsgate\CmsPlugin"))
    require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/cmsgate-core/src/esas/cmsgate/CmsPlugin.php');

class CmsPluginCloud extends CmsPlugin
{
    /**
     * @var CloudRegistry
     */
    private $cloudRegistry;

    public function __construct($composerVendorDir, $cmsPluginDir)
    {
        parent::__construct($composerVendorDir, $cmsPluginDir);
    }

    /**
     * @param CloudRegistry $cloudRegistry
     * @return CmsPlugin
     */
    public function setCloudRegistry($cloudRegistry)
    {
        $this->cloudRegistry = $cloudRegistry;
        return $this;
    }

    public function init()
    {
        parent::init();
        $this->cloudRegistry->init();
    }

}