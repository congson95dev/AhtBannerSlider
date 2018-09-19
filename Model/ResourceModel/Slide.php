<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/07/2018
 * Time: 3:28 CH
 */

namespace Aht\BannerSlider\Model\ResourceModel;


class Slide extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('slide', 'id');
    }

}