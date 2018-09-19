<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21/07/2018
 * Time: 10:43 SA
 */

namespace Aht\BannerSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action\Context;
use Aht\BannerSlider\Model\BannerSlideFactory;
use Aht\BannerSlider\Model\ResourceModel\BannerSlide as ResourceModel;

class Remove extends \Magento\Framework\App\Action\Action
{
    /**
     * @var BannerSlideFactory
     */
    protected $bannerSlideFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    public function __construct(
        Context $context,
        BannerSlideFactory $bannerSlideFactory,
        ResourceModel $resourceModel
    ) {
        $this->resourceModel = $resourceModel;
        $this->bannerSlideFactory = $bannerSlideFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try{
            /** @var \Aht\BannerSlider\Model\BannerSlide $model */

            $id = $this->getRequest()->getParam('id');

//                The 1st way :
            $banner_slide = $this->bannerSlideFactory->create()->getCollection();
            $banner_slide->addFieldToFilter('slide_id',$id);
            foreach ($banner_slide as $rows){
                $rows->delete();
            }

//                  The 2nd way :
//            $model = $this->bannerSlideFactory->create();
//            $resource = $this->resourceModel->load($model,$id);
//            $resource->delete($model);


            $this->messageManager->addSuccessMessage(__('Remove Slide Successfully.'));

            // Redirect back
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
        catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}