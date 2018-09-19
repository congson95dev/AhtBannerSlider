<?php

namespace Aht\BannerSlider\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Aht\BannerSlider\Model\BannerFactory;

class Detail extends \Magento\Backend\App\Action
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
        $id = $this->getRequest()->getParam('id');
        $banner = $this->_bannerFactory->create()->load($id);
        $result = $this->_resultPageFactory->create();
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('banner', $banner);
        return $result;
    }
}