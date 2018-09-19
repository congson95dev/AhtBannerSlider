<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aht\BannerSlider\Controller\Adminhtml\Slide;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Aht\BannerSlider\Helper\Image as ImageHelper;
use Aht\BannerSlider\Model\ResourceModel\Slide\CollectionFactory as SlideCollectionFactory;

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
    const ADMIN_RESOURCE = 'Aht_BannerSlider::slides';

    /**
     * @var Filter
     */
    protected $filter;

    protected $slideCollectionFactory;

    protected $imageHelper;

    public function __construct(
        Context $context,
        Filter $filter,
        SlideCollectionFactory $slideCollectionFactory,
        ImageHelper $imageHelper
    )
    {
        $this->filter = $filter;
        $this->slideCollectionFactory = $slideCollectionFactory;
        $this->imageHelper = $imageHelper;
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
        $slideCollection = $this->filter->getCollection($this->slideCollectionFactory->create());
        $collectionSize = $slideCollection->getSize();

        foreach ($slideCollection as $slide) {
            $oldImage = $slide->getImage();
            $this->imageHelper->unlinkImage($oldImage);
            $slide->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
