<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/07/2018
 * Time: 3:28 CH
 */

namespace Aht\BannerSlider\Model\ResourceModel;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('banner', 'id');
    }

    public function getBannerSlideTable()
    {
        return $this->getTable('banner_slide');
    }

    public function getSlidePosition($banner)
    {
        $select = $this->getConnection()->select()->from(
            $this->getBannerSlideTable(),
            ['slide_id', 'position']
        )->where(
            'banner_id = :banner_id'
        );
        $bind = ['banner_id' => (int)$banner->getId()];

        return $this->getConnection()->fetchPairs($select, $bind);
    }

}