<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21/07/2018
 * Time: 10:43 SA
 */

namespace Aht\BannerSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action\Context;
use Aht\BannerSlider\Model\SlideFactory;
use Aht\BannerSlider\Model\ResourceModel\Slide as ResourceModel;

class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var SlideFactory
     */
    protected $slideFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    public function __construct(
        Context $context,
        SlideFactory $slideFactory,
        ResourceModel $resourceModel
    ) {
        $this->resourceModel = $resourceModel;
        $this->slideFactory = $slideFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try{
            /** @var \Aht\BannerSlider\Model\Slide $model */

            $id = $this->getRequest()->getParam('id');

//                The 1st way :
//            $model = $this->studentsFactory->create()->load($id);
//            $model->delete();

//                  The 2nd way :
                $model = $this->slideFactory->create();
                $resource = $this->resourceModel->load($model,$id);
                $resource->delete($model);


            $this->messageManager->addSuccessMessage(__('Delete Slide Successfully.'));

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect->setPath('*/*/index');

            return $resultRedirect;
        }
        catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}