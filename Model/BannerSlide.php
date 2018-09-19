<?php
namespace Aht\BannerSlider\Model;

use \Aht\BannerSlider\Api\Data\BannerSlideInterface;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

class BannerSlide extends AbstractModel implements BannerSlideInterface, IdentityInterface
{
    const CACHE_TAG = 'banner_slider';

    protected function _construct()
    {
        $this->_init('Aht\BannerSlider\Model\ResourceModel\BannerSlide');
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
     * Get Banner Id
     *
     * @return string|null
     */
    public function getBannerId(){
        return $this->getData(self::BANNER_ID);
    }

    /**
     * Get Slide Id
     *
     * @return string|null
     */
    public function getSlideId(){
        return $this->getData(self::SLIDE_ID);
    }

    /**
     * Get Position
     *
     * @return string|null
     */
    public function getPosition(){
        return $this->getData(self::POSITION);
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
     * Set Banner Id
     *
     * @param string $banner_id
     * @return $this
     */
    public function setBannerId($banner_id){
        return $this->setData(self::BANNER_ID, $banner_id);
    }

    /**
     * Set Slide Id
     *
     * @param string $slide_id
     * @return $this
     */
    public function setSlideId($slide_id){
        return $this->setData(self::SLIDE_ID, $slide_id);
    }

    /**
     * Set Position
     *
     * @param string $position
     * @return $this
     */
    public function setPosition($position){
        return $this->setData(self::POSITION, $position);
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