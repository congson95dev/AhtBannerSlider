<?php

namespace Aht\BannerSlider\Block\Adminhtml;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Backend\Model\UrlInterface;

use \Aht\BannerSlider\Model\BannerFactory;
use \Aht\BannerSlider\Model\SlideFactory;
use \Aht\BannerSlider\Model\BannerSlideFactory;
use \Aht\BannerSlider\Model\BannerPageFactory;

use \Aht\BannerSlider\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use \Aht\BannerSlider\Model\ResourceModel\Slide\CollectionFactory as SlideCollectionFactory;
use \Aht\BannerSlider\Model\ResourceModel\BannerSlide\CollectionFactory as BannerSlideCollectionFactory;
use \Aht\BannerSlider\Model\ResourceModel\BannerPage\CollectionFactory as BannerPageCollectionFactory;


class Index extends Template
{
    /**
     * CollectionFactory (important to put CollectionFactory here,else, it will be issue)
     * @var null|CollectionFactory
     */

    protected $_bannerFactory = null;

    protected $_slideFactory = null;

    protected $_bannerSlideFactory = null;

    protected $_bannerPageFactory = null;

    protected $_bannerCollectionFactory = null;

    protected $_slideCollectionFactory = null;

    protected $_bannerSlideCollectionFactory = null;

    protected $_bannerPageCollectionFactory = null;

    protected $_backendUrl = null;

    public function __construct(
        Context $context,
        BannerCollectionFactory $bannerCollectionFactory,
        SlideCollectionFactory $slideCollectionFactory,
        BannerSlideCollectionFactory $bannerSlideCollectionFactory,
        BannerPageCollectionFactory $bannerPageCollectionFactory,

        BannerFactory $bannerFactory,
        SlideFactory $slideFactory,
        BannerSlideFactory $bannerSlideFactory,
        BannerPageFactory $bannerPageFactory,

        UrlInterface $backendUrl,
        array $data = []
    ) {
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_slideCollectionFactory = $slideCollectionFactory;
        $this->_bannerSlideCollectionFactory = $bannerSlideCollectionFactory;
        $this->_bannerPageCollectionFactory = $bannerPageCollectionFactory;

        $this->_bannerFactory = $bannerFactory;
        $this->_slideFactory = $slideFactory;
        $this->_bannerSlideFactory = $bannerSlideFactory;
        $this->_bannerPageFactory = $bannerPageFactory;

        $this->_backendUrl = $backendUrl;
        parent::__construct($context, $data);
    }

//    public function getBanner()
//    {
//        $bannerCollection = $this->_bannerCollectionFactory->create();
//        $bannerCollection->addFieldToSelect('*')->load();
//        return $bannerCollection->getItems();
//    }

//    public function getAddBannerUrl(){
//        $route = "banners/banner/add/";
//        $params = [];
//        return $this->getUrl($route, $params);
//    }
//
//    public function getBannerById(){
//        $id = $this->getRequest()->getParam('id');
//        $student = $this->_bannerSliderFactory->create();
//        $student->load($id);
//        return $student;
//    }
}
