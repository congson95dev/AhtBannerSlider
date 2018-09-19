<?php

namespace Aht\BannerSlider\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Aht\BannerSlider\Model\BannerFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * News model factory
     *
     * @var \Aht\BannerSlider\Model\BannerFactory
     */
    protected $_bannerFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param BannerFactory $bannerFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        BannerFactory $bannerFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_bannerFactory = $bannerFactory;
    }

    /**
     * News access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Aht_BannerSlider::banners');
    }

    public function execute()
    {
        $this->_bannerFactory->create();
        $result = $this->_resultPageFactory->create();
        return $result;
    }
}