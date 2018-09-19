<?php
namespace Aht\BannerSlider\Model;

use \Aht\BannerSlider\Api\Data\SlideInterface;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

class Slide extends AbstractModel implements SlideInterface, IdentityInterface
{
    const CACHE_TAG = 'slide';

    protected function _construct()
    {
        $this->_init('Aht\BannerSlider\Model\ResourceModel\Slide');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId(){
        return $this->getData(self::ID);
    }

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName(){
        return $this->getData(self::NAME);
    }

    /**
     * Get Url
     *
     * @return string|null
     */
    public function getUrl(){
        return $this->getData(self::URL);
    }

    /**
     * Get Image
     *
     * @return string|null
     */
    public function getImage(){
        return $this->getData(self::IMAGE);
    }

    /**
     * Get Created At
     *
     * @return string|null
     */
    public function getCreatedAt(){
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get Updated At
     *
     * @return string|null
     */
    public function getUpdatedAt(){
        return $this->getData(self::UPDATED_AT);
    }


    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id){
        return $this->setData(self::ID, $id);
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name){
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set Url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url){
        return $this->setData(self::URL, $url);
    }

    /**
     * Set Image
     *
     * @param string $image
     * @return $this
     */
    public function setImage($image){
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Set Created At
     *
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt){
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set Updated At
     *
     * @param int $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt){
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}