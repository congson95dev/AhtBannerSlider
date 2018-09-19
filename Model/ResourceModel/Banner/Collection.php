<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/07/2018
 * Time: 3:31 CH
 */

namespace Aht\BannerSlider\Model\ResourceModel\Banner;



class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
//    protected $_eventPrefix = 'students_collection';
//    protected $_eventObject = 'students_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aht\BannerSlider\Model\Banner', 'Aht\BannerSlider\Model\ResourceModel\Banner');
    }

}