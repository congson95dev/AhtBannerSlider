<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Aht\BannerSlider\Block\Adminhtml\Banner;

//use Aht\BannerSlider\Block\Adminhtml\Banner\Tab\Slide;

class AssignSlide extends \Magento\Backend\Block\Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'banner_slide/banner/edit/assign_slide.phtml';

    /**
     * @var \Aht\BannerSlider\Block\Adminhtml\Banner\Tab\Slide
     */
    protected $blockGrid;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    protected $_bannerSlideFactory;
    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Aht\BannerSlider\Model\BannerSlideFactory $bannerSlideFactory,
//        Slide $blockGrid,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->jsonEncoder = $jsonEncoder;
        $this->_bannerSlideFactory = $bannerSlideFactory;
//        $this->blockGrid = $blockGrid;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                \Aht\BannerSlider\Block\Adminhtml\Banner\Tab\Slide::class,
                'banner.slide.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * @return string
     */
    public function getSlideJson()
    {
        $slide = $this->getBanner()->getSlidePosition();
        if (!empty($slide)) {
            return $this->jsonEncoder->encode($slide);
        }
        return '{}';
    }
    /**
     * Retrieve current category instance
     *
     * @return array|null
     */
    public function getBanner()
    {
        return $this->registry->registry('banner');
    }
}
