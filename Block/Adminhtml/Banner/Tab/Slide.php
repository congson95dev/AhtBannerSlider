<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Slide in banner grid
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Aht\BannerSlider\Block\Adminhtml\Banner\Tab;

use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;

class Slide extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Aht\BannerSlider\Model\SlideFactory
     */
    protected $_slideFactory;

    protected $_bannerSlideFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Aht\BannerSlider\Model\SlideFactory $slideFactory,
        \Aht\BannerSlider\Model\BannerSlideFactory $bannerSlideFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_slideFactory = $slideFactory;
        $this->_bannerSlideFactory = $bannerSlideFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('banner_slider_banner_slide');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

    /**
     * @return array|null
     */
    public function getBanner()
    {
        return $this->_coreRegistry->registry('banner');
    }

    /**
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
//        $field = $column->getFilterIndex() ? $column->getFilterIndex() : $column->getIndex();

        if ($column->getId() == 'in_banner') {
            $slideIds = $this->_getSelectedSlide();
            if (empty($slideIds)) {
                $slideIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('main_table.id', ['in' => $slideIds]);
            } elseif (!empty($slideIds)) {
                $this->getCollection()->addFieldToFilter('main_table.id', ['nin' => $slideIds]);
//                echo $this->getCollection()->getSelect();
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @return Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_slideFactory->create()->getCollection();
//            ->addFieldToSelect(array('id', 'name', 'image'));

//        check id vì 2 TH , add và update
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(['in_banner' => 1]);

//            main_table được lấy tự động.
            $collection->getSelect()
            ->joinLeft(
                ['banner_slide' => 'banner_slide'],
                'main_table.id = banner_slide.slide_id and banner_slide.banner_id = '. $this->getBanner()->getId(),
                ['banner_id','position']
            );
//            ->where('banner_id = ?', $this->getBanner()->getId());

//            phải để addFilterToMap ở bên ngoài thì mới chạy được filter by created_at.
//            nó thay created_at = main_table.created_at
            $collection->addFilterToMap('created_at', 'main_table.created_at');
            $collection->addFilterToMap('updated_at', 'main_table.updated_at');
            $collection->addFilterToMap('id', 'main_table.id');

//            hiển thị câu lệnh sql:
//            echo $collection->getSelect();die();

        } else {
            $collection->addFieldToSelect('*')->load();
            $collection->getItems();
            $collection->addFilterToMap('created_at', 'main_table.created_at');
            $collection->addFilterToMap('updated_at', 'main_table.updated_at');
        }


        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_banner',
            [
                'type' => 'checkbox',
                'name' => 'in_banner',
                'values' => $this->_getSelectedSlide(),
                'index' => 'id',
                'header_css_class' => 'col-select col-massaction',
                'column_css_class' => 'col-select col-massaction'
            ]
        );
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn('name', ['header' => __('Name'), 'index' => 'name']);
        $this->addColumn('url', ['header' => __('URL'), 'index' => 'url']);
        $this->addColumn('image', ['header' => __('Image'), 'index' => 'image']);

        $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'type' => 'number',
                'index' => 'position',
                'editable' => true
            ]
        );
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created Time'),
                'type' => 'datetime',
                'index' => 'created_at'
            ]
        );
        $this->addColumn(
            'updated_at',
            [
                'header' => __('Last Update'),
                'type' => 'datetime',
                'index' => 'updated_at'
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Remove'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Remove'),
                        'url' => [
                            'base' => 'banner/slide/remove'
                        ],
                        'confirm' => 'Are you sure?',
                        'field' => 'id'
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('banner/*/grid', ['_current' => true]);
    }

    /**
     * @return array
     */
    protected function _getSelectedSlide()
    {
        // get slide position trong bảng banner_slide
        $slide = $this->getRequest()->getPost('selected_slide');
        if ($slide === null) {
            if ($this->getRequest()->getParam('id')) {
                $slide = $this->getBanner()->getSlidePosition();
                return array_keys($slide);
            }
        }
        return $slide;
    }
}
