<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aht\BannerSlider\Controller\Adminhtml\Manage;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Aht\BannerSlider\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Aht_BannerSlider::banners';

    /**
     * @var Filter
     */
    protected $filter;

    protected $bannerCollectionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        BannerCollectionFactory $bannerCollectionFactory
    )
    {
        $this->filter = $filter;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $bannerCollection = $this->filter->getCollection($this->bannerCollectionFactory->create());
        $collectionSize = $bannerCollection->getSize();

        foreach ($bannerCollection as $banner) {
            $banner->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
