<?php

namespace Aht\BannerSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Aht\BannerSlider\Model\SlideFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;

    protected $_slideFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        SlideFactory $slideFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_slideFactory = $slideFactory;
    }

    /**
     * News access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Aht_BannerSlider::slides');
    }

    public function execute()
    {
        $this->_slideFactory->create();
        $result = $this->_resultPageFactory->create();
        return $result;
    }
}