<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20/07/2018
 * Time: 4:15 CH
 */

namespace Aht\BannerSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action\Context;
use Aht\BannerSlider\Model\SlideFactory;
use Magento\Catalog\Model\ImageUploader;
use Aht\BannerSlider\Helper\Image as ImageHelper;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $slideFactory;

    protected $imageUploader;

    protected $imageHelper;

    public function __construct(
        Context $context,
        SlideFactory $slideFactory,
        ImageUploader $imageUploader,
        ImageHelper $imageHelper
    ) {
        $this->slideFactory = $slideFactory;
        $this->imageUploader = $imageUploader;
        $this->imageHelper = $imageHelper;
        parent::__construct($context);
    }
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
//
        if ($data) {
            try{
                $id = $this->getRequest()->getParam('id');
                $model = $this->slideFactory->create();
                if($id){
                    $model->load($id);
                    $data['id'] = $id;
                }

                // Add image to data
                if(isset($data['image']) && is_array($data['image'])){
                    $data['image']=$data['image'][0]['name'];

//                    Move img từ tmp folder sang base folder (Aht_BannerSlider/images)
                    $this->imageUploader->setBaseTmpPath('Aht_BannerSlider/tmp/images');
                    $this->imageUploader->setBasePath('Aht_BannerSlider/images');
                    $this->imageUploader->moveFileFromTmp($data['image']);

//                    xóa ảnh trong base folder nếu như đang Edit Slide.
                    if($id){
                        $oldImage = $this->slideFactory->create()->load($id)->getImage();
                        $this->imageHelper->unlinkImage($oldImage);
                    }
                }

                $model->setData($data);
                $model->save();

                if ($id) {
                    $this->messageManager->addSuccessMessage(__('Update Slide Successfully.'));
                } else {
                    $this->messageManager->addSuccessMessage(__('Add Slide Successfully.'));
                }

//              check for Save and Continue Edit Button
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/detail', ['id' => $model->getId(), '_current' => true]);
                } else {
                    $resultRedirect->setPath('*/*/');
                }

                return $resultRedirect;
            }
            catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

        }
    }
}