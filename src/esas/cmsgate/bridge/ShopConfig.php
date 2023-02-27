<?php


namespace esas\cmsgate\bridge;


class ShopConfig
{
    private $uuid;

    private $configArray;

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getConfigArray()
    {
        return $this->configArray;
    }

    public function addToConfigArray($key, $value) {
        $this->configArray[$key] = $value;
        return $this;
    }

    /**
     * @param mixed $configArray
     */
    public function setConfigArray($configArray)
    {
        $this->configArray = $configArray;
    }


}