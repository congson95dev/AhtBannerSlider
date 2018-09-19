<?php
namespace Aht\BannerSlider\Model;

use \Aht\BannerSlider\Api\Data\BannerInterface;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

class Page extends AbstractModel implements BannerInterface, IdentityInterface
{
    const CACHE_TAG = 'page';

    protected function _construct()
    {
        $this->_init('Aht\BannerSlider\Model\ResourceModel\Page');
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
     * Get URL
     *
     * @return string|null
     */
    public function getUrl(){
        return $this->getData(self::URL);
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


    public function getSlidePosition()
    {
        if (!$this->getId()) {
            return [];
        }

        $array = $this->getData('slide_position');
        if ($array === null) {
            $array = $this->getResource()->getSlidePosition($this);
            $this->setData('slide_position', $array);
        }
        return $array;
    }
}