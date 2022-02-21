<?php


namespace esas\cmsgate;


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