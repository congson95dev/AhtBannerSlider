<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21/07/2018
 * Time: 10:43 SA
 */

namespace Aht\BannerSlider\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action\Context;
use Aht\BannerSlider\Model\BannerFactory;
use Aht\BannerSlider\Model\ResourceModel\Banner as ResourceModel;

class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var BannerFactory
     */
    protected $bannerFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    public function __construct(
        Context $context,
        BannerFactory $bannerFactory,
        ResourceModel $resourceModel
    ) {
        $this->resourceModel = $resourceModel;
        $this->bannerFactory = $bannerFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        try{
            /** @var \Aht\BannerSlider\Model\Banner $model */

            $id = $this->getRequest()->getParam('id');

//                The 1st way :
//            $model = $this->studentsFactory->create()->load($id);
//            $model->delete();

//                  The 2nd way :
                $model = $this->bannerFactory->create();
                $resource = $this->resourceModel->load($model,$id);
                $resource->delete($model);


            $this->messageManager->addSuccessMessage(__('Delete Banner Successfully.'));

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect->setPath('*/*/index');

            return $resultRedirect;
        }
        catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
}