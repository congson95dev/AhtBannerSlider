<?php
namespace Aht\BannerSlider\Model;

use \Aht\BannerSlider\Api\Data\BannerPageInterface;
use \Magento\Framework\DataObject\IdentityInterface;
use \Magento\Framework\Model\AbstractModel;

class BannerPage extends AbstractModel implements BannerPageInterface, IdentityInterface
{
    const CACHE_TAG = 'banner_page';

    protected function _construct()
    {
        $this->_init('Aht\BannerSlider\Model\ResourceModel\BannerPage');
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
     * Get Page Url
     *
     * @return string|null
     */
    public function getPageId(){
        return $this->getData(self::PAGE_ID);
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
     * Set Page ID
     *
     * @param string $page_id
     * @return $this
     */
    public function setPageId($page_id){
        return $this->setData(self::PAGE_ID, $page_id);
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