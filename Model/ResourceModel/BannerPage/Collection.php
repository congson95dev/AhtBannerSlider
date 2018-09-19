<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/07/2018
 * Time: 3:31 CH
 */

namespace Aht\BannerSlider\Model\ResourceModel\BannerPage;



class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aht\BannerSlider\Model\BannerPage', 'Aht\BannerSlider\Model\ResourceModel\BannerPage');
    }

}