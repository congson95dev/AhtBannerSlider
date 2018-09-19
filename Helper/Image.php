<?php

namespace Aht\BannerSlider\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Action\Action;
class Image extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Custom directory relative to the "media" folder
     */
    const DIRECTORY = 'Aht_BannerSlider/images';

//    const TMP_DIRECTORY = 'Aht_BannerSlider/tmp/images';

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    protected $_mediaDirectory;

    /**
     * @var \Magento\Framework\Image\Factory
     */
    protected $_imageFactory;

    protected $_storeManager;

    protected $action;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Image\Factory $imageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Action\Action $action
    ) {
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_imageFactory = $imageFactory;
        $this->_storeManager = $storeManager;
        $this->action = $action;
        parent::__construct($context);
    }

    /**
     * First check this file on FS
     *
     * @param string $filename
     * @return bool
     */
    protected function _fileExists($filename)
    {
        if ($this->_mediaDirectory->isFile($filename)) {
            return true;
        }
        return false;
    }

    /**
     * Resize image
     * @return string
     */
    public function resize($image, $width = null, $height = null)
    {
        $mediaFolder = self::DIRECTORY;

        $path = $mediaFolder . '/resize';

        $absolutePath = $this->_mediaDirectory->getAbsolutePath($mediaFolder) .'/'. $image;
        $imageResized = $this->_mediaDirectory->getAbsolutePath($path).'/'. $image;

        if (!$this->_fileExists($path . $image)) {
            $imageFactory = $this->_imageFactory->create();
            $imageFactory->open($absolutePath);
            $imageFactory->constrainOnly(true);
            $imageFactory->keepTransparency(true);
            $imageFactory->keepFrame(true);
            // background Color nhằm không hiển thị khoảng đen sau khi resize.
            $imageFactory->backgroundColor(array(255,255,255));
            $imageFactory->keepAspectRatio(true);
            $imageFactory->resize($width, $height);
            $imageFactory->save($imageResized);
        }

        return $this->_storeManager
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $path .'/'. $image;
    }

    public function unlinkImage($image){
        $mediaFolder = self::DIRECTORY;

        $imagePath = $this->_mediaDirectory->getAbsolutePath($mediaFolder) .'/'. $image;

        if ($this->_fileExists($imagePath)) {
            unlink($imagePath);
        }
    }
}