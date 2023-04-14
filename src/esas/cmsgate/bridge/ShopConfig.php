<?php


namespace esas\cmsgate\bridge;


class ShopConfig
{
    private $id;
    private $merchantId;
    private $configArray;

    /**
     * @deprecated
     * @return mixed
     */
    public function getUuid()
    {
        return $this->getId();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @deprecated
     * @param mixed $uuid
     * @return ShopConfig
     */
    public function setUuid($uuid)
    {
        return $this->setId($uuid);
    }

    /**
     * @param mixed $uuid
     * @return ShopConfig
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantId() {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     * @return ShopConfig
     */
    public function setMerchantId($merchantId) {
        $this->merchantId = $merchantId;
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