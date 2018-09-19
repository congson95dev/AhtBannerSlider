<?php

namespace Aht\BannerSlider\Helper;

use Magento\Framework\View\Element\Template;
use \Aht\BannerSlider\Model\ResourceModel\BannerPage\CollectionFactory as BannerPageCollectionFactory;

class Check extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $template;

    protected $_bannerPageCollectionFactory = null;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Template $template,
        BannerPageCollectionFactory $bannerPageCollectionFactory
    )
    {
        parent::__construct($context);
        $this->template = $template;
        $this->_bannerPageCollectionFactory = $bannerPageCollectionFactory;
    }

    public function checkAllowedPage()
    {
//        $currentUrl = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
//        $substrUrl = $currentUrl;

        $route = $this->template->getRequest()->getRouteName();
        $controller = $this->template->getRequest()->getControllerName();
        $action = $this->template->getRequest()->getActionName();
        $param = $this->template->getRequest()->getParam('id');

        $full_route = '';
        if (!empty($param)) {
            $full_route = $route . '/' . $controller . '/' . $action . '/id/' . $param;
        } else {
            $full_route = $route . '/' . $controller . '/' . $action;
        }

        $bannerPageCollection = $this->_bannerPageCollectionFactory->create();
        $banner_page = $bannerPageCollection
            ->join('page', 'main_table.page_id = page.id', ['main_table.banner_id'])
            ->addFieldToFilter('page_url', array('eq' => $full_route))
            ->count();

        if ($banner_page > 0) {
            return $full_route;
        }
        return false;
    }
};