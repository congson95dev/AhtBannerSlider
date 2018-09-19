<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21/07/2018
 * Time: 9:22 CH
 */

namespace Aht\BannerSlider\Block\Frontend;

use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\View\Element\Template;

use \Aht\BannerSlider\Model\BannerFactory as BannerFactory;
use \Aht\BannerSlider\Model\SlideFactory as SlideFactory;
use \Aht\BannerSlider\Model\BannerSlideFactory as BannerSlideFactory;
use \Aht\BannerSlider\Model\BannerSlideFactory as BannerPageFactory;

use \Aht\BannerSlider\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use \Aht\BannerSlider\Model\ResourceModel\Slide\CollectionFactory as SlideCollectionFactory;
use \Aht\BannerSlider\Model\ResourceModel\BannerSlide\CollectionFactory as BannerSlideCollectionFactory;
use \Aht\BannerSlider\Model\ResourceModel\BannerPage\CollectionFactory as BannerPageCollectionFactory;

class Index extends Template
{
    protected $_bannerFactory = null;

    protected $_slideFactory = null;

    protected $_bannerSlideFactory = null;

    protected $_bannerPageFactory = null;

    protected $_bannerCollectionFactory = null;

    protected $_slideCollectionFactory = null;

    protected $_bannerSlideCollectionFactory = null;

    protected $_bannerPageCollectionFactory = null;

    protected $_filesystem ;

    protected $_imageFactory;

    protected $coreRegistry;

    public function __construct(
        Context $context,
        BannerFactory $bannerFactory,
        SlideFactory $slideFactory,
        BannerSlideFactory $bannerSlideFactory,
        BannerPageFactory $bannerPageFactory,
        BannerCollectionFactory $bannerCollectionFactory,
        SlideCollectionFactory $slideCollectionFactory,
        BannerSlideCollectionFactory $bannerSlideCollectionFactory,
        BannerPageCollectionFactory $bannerPageCollectionFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        $this->_bannerFactory = $bannerFactory;
        $this->_slideFactory = $slideFactory;
        $this->_bannerSlideFactory = $bannerSlideFactory;
        $this->_bannerPageFactory = $bannerPageFactory;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_slideCollectionFactory = $slideCollectionFactory;
        $this->_bannerSlideCollectionFactory = $bannerSlideCollectionFactory;
        $this->_bannerPageCollectionFactory = $bannerPageCollectionFactory;
        $this->_filesystem = $filesystem;
        $this->_imageFactory = $imageFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    public function getBannerSlideById($banner_id)
    {
        $bannerSlideCollection = $this->_bannerSlideCollectionFactory->create();
        $bannerSlideCollection
            ->addFieldToSelect('slide_id')
            ->addFieldToFilter('banner_id', array('eq' => $banner_id))
            ->addOrder('position','DESC');
//        nếu có position thì load id theo position giảm dần.
//            ->load($banner_id);
        return $bannerSlideCollection->getItems();
    }

    public function getSlideById($slide_id)
    {
        $slide = $this->_slideFactory->create();
        $slide->load($slide_id);
        return $slide;
    }

    public function checkAllowedPage()
    {
//        $currentUrl = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
//        $substrUrl = $currentUrl;

        $route      = $this->getRequest()->getRouteName();
        $controller = $this->getRequest()->getControllerName();
        $action     = $this->getRequest()->getActionName();
        $param      = $this->getRequest()->getParam('id');

        $full_route = '';
        if(!empty($param))
        {
            $full_route = $route .'/'. $controller .'/'. $action .'/id/'. $param;
        } else {
            $full_route = $route .'/'. $controller .'/'. $action;
        }

        $bannerPageCollection = $this->_bannerPageCollectionFactory->create();
        $banner_page = $bannerPageCollection
            ->join('page', 'main_table.page_id = page.id', ['main_table.banner_id'])
            ->addFieldToFilter('page_url', array('eq' => $full_route))
            ->getData();

            if(!empty($banner_page)){
                return $banner_page;
            }
        return false;
    }

    public function getResolutionScreen(){
        $resolution_screen = $this->coreRegistry->registry('resolution_screen');
        return $resolution_screen;
    }
}