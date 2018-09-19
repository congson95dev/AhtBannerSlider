<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20/07/2018
 * Time: 4:15 CH
 */

namespace Aht\BannerSlider\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action\Context;
use Aht\BannerSlider\Model\BannerFactory;
use Aht\BannerSlider\Model\PageFactory;
use Aht\BannerSlider\Model\BannerSlideFactory;
use Aht\BannerSlider\Model\BannerPageFactory;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $bannerFactory;

    protected $bannerSlideFactory;

    protected $bannerPageFactory;

    protected $pageFactory;

    public function __construct(
        Context $context,
        BannerFactory $bannerFactory,
        PageFactory $pageFactory,
        BannerSlideFactory $bannerSlideFactory,
        BannerPageFactory $bannerPageFactory
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->pageFactory = $pageFactory;
        $this->bannerSlideFactory = $bannerSlideFactory;
        $this->bannerPageFactory = $bannerPageFactory;

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

                $banner = $this->bannerFactory->create();

                if($id) {
//                delete toàn bộ bản ghi rùi insert lại những bản ghi có trong chuỗi json banner_slide
                    $bannerSelected = $this->bannerSlideFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('banner_id', $id);

                    foreach ($bannerSelected as $bannerDelete) {
                        $bannerDelete->delete();
                    }

//                    delete toàn bộ bản ghi rùi insert lại những bản ghi có trong banner_page post lên.
                    $bannerPageSelected = $this->bannerPageFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('banner_id', $id);

                    foreach ($bannerPageSelected as $bannerPageDelete) {
                        $bannerPageDelete->delete();
                    }
                }

                if($id){
                    $banner->load($id);
                    $data['id'] = $id;
                }
                $banner->setData($data);
                $banner->save();

                if(isset($data['banner_slide'])){
//                    lấy chuỗi json banner_slide được truyền vào từ form HTML.
                    $slide = json_decode($data['banner_slide'], true);
                    foreach($slide as $key => $value){
                        $bannerSlide = $this->bannerSlideFactory->create();

//                        insert banner trước xong mới lấy id của banner để insert vào banner_slide
                        $banner_id = $banner->getId();
                        $bannerSlide->setBannerId($banner_id);
                        $bannerSlide->setSlideId($key);
                        $bannerSlide->setPosition($value);
                        $bannerSlide->save();
                    }
                }

                if(isset($data['use_config'])){
                    if($data['use_config']['banner_page'] == 'true'){
                        $page = $this->pageFactory->create()->getCollection();
                        $page->getData();
                        foreach ($page as $rows){
                            $bannerPageFactory = $this->bannerPageFactory->create();
                            $banner_id = $banner->getId();
                            $bannerPageFactory->setBannerId($banner_id);
                            $bannerPageFactory->setPageId($rows['id']);
                            $bannerPageFactory->save();
                        }
                    } else {
                        if(isset($data['banner_page'])){
//                    lấy banner_page được truyền vào từ post.
                            $banner_page_post = $data['banner_page'];
                            foreach($banner_page_post as $key => $value){
                                $bannerPageFactory = $this->bannerPageFactory->create();

//                        insert banner trước xong mới lấy id của banner để insert vào banner_page
                                $banner_id = $banner->getId();
                                $bannerPageFactory->setBannerId($banner_id);
                                $bannerPageFactory->setPageId($value);
                                $bannerPageFactory->save();
                            }
                        }
                    }
                }


                if ($id) {
                    $this->messageManager->addSuccessMessage(__('Update Banner Successfully.'));
                } else {
                    $this->messageManager->addSuccessMessage(__('Add Banner Successfully.'));
                }

//              check for Save and Continue Edit Button
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/detail', ['id' => $banner->getId(), '_current' => true]);
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