<?php

namespace Aht\BannerSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Aht\BannerSlider\Model\SlideFactory;

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
     * @var \Aht\BannerSlider\Model\SlideFactory
     */
    protected $_slideFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param SlideFactory $slideFactory
     */
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
        $id = $this->getRequest()->getParam('id');
        $slide = $this->_slideFactory->create()->load($id);
        $result = $this->_resultPageFactory->create();
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('slide', $slide);
        return $result;
    }
}