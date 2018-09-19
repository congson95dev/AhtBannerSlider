<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aht\BannerSlider\Controller\Adminhtml\Manage;

use Aht\BannerSlider\Model\BannerFactory;

class Grid extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * News model factory
     *
     * @var \Aht\BannerSlider\Model\BannerFactory
     */
    protected $bannerFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        BannerFactory $bannerFactory
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory = $layoutFactory;
        $this->bannerFactory = $bannerFactory;
    }

    /**
     * Grid Action
     * Display list of products related to current banner
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
//    meanless file
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $banner = $this->bannerFactory->create()->load($id);
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('banner', $banner);
        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_banner', $banner);
        if (!$banner) {
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('banner/*/', ['_current' => true, 'id' => null]);
        }
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                \Aht\BannerSlider\Block\Adminhtml\Banner\Tab\Slide::class,
                'banner.slide.grid'
            )->toHtml()
        );
    }
}
