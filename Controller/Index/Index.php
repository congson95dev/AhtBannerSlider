<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/07/2018
 * Time: 4:35 CH
 */

namespace Aht\BannerSlider\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_bannerFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Aht\BannerSlider\Model\BannerFactory $bannerFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_bannerFactory = $bannerFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $this->_bannerFactory->create();
        $result = $this->_pageFactory->create();
        return $result;
    }
}