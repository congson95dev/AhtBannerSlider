<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Aht\BannerSlider\Model\Slide;

use Aht\BannerSlider\Model\ResourceModel\Slide\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use \Magento\Backend\App\Action;
/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    const DIRECTORY = 'Aht_BannerSlider/images/';
    /**
     * @var \Aht\BannerSlider\Model\ResourceModel\Slide\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    protected $action;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $slideCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $slideCollectionFactory,
        DataPersistorInterface $dataPersistor,
        Action $action,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $slideCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->action = $action;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $slide \Aht\BannerSlider\Model\Slide */
        foreach ($items as $slide) {
            $this->loadedData[$slide->getId()] = $slide->getData();
        }

//        $data = $this->dataPersistor->get('cms_slide');
//        if (!empty($data)) {
//            $slide = $this->collection->getNewEmptyItem();
//            $slide->setData($data);
//            $this->loadedData[$slide->getId()] = $slide->getData();
//            $this->dataPersistor->clear('cms_slide');
//        }

        /* For Modify  You custom image field data */
        if ($this->action->getRequest()->getParam('id')) {
            if (!empty($this->loadedData[$slide->getId()]['image'])) {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
                $currentStore = $storeManager->getStore();
                $media_url = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

                $path = self::DIRECTORY;
                $image_name = $this->loadedData[$slide->getId()]['image'];
                unset($this->loadedData[$slide->getId()]['image']);
                $this->loadedData[$slide->getId()]['image'][0]['name'] = $image_name;
                $this->loadedData[$slide->getId()]['image'][0]['url'] = $media_url . $path . $image_name;
            }
        }

        return $this->loadedData;
    }
}
