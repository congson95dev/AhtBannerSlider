<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 17/07/2018
 * Time: 4:35 CH
 */

namespace Aht\BannerSlider\Controller\Slide;

class Image extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $coreRegistry;

    protected $resultJsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        $this->coreRegistry = $coreRegistry;
        $this->_pageFactory = $pageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
//      gửi width,height và full_route qua block bằng register

        $html = '';
        $errorMessage = false;
        $resultJson = $this->resultJsonFactory->create();
        try{
            $width = $this->getRequest()->getParam('width');
            $height = $this->getRequest()->getParam('height');
            $full_route = $this->getRequest()->getParam('full_route');

            $resolution_screen = array($width,$height);

            $this->coreRegistry->register('resolution_screen', $resolution_screen);
            $this->coreRegistry->register('full_route', $full_route);

            $resultPage = $this->_pageFactory->create();

            $html = $resultPage->getLayout()
                ->createBlock('Aht\BannerSlider\Block\Frontend\Slide')
                ->setTemplate('Aht_BannerSlider::slide.phtml')
                ->toHtml();

        } catch (\Exception $e){
            $errorMessage = 'There is something wrong!';
//            $this->messageManager->addErrorMessage($errorMessage);
            $respone = $resultJson->setData(['errorMessage' => $errorMessage]);
            return $respone;
        }

        $respone = $resultJson->setData(['html' => $html, 'errorMessage' => $errorMessage]);

        return $respone;
    }
}