<?php

namespace Aht\BannerSlider\Model\Page;

use Aht\BannerSlider\Model\ResourceModel\Page\CollectionFactory;

class PageSource implements \Magento\Framework\Option\ArrayInterface
{
    protected $pageCollectionFactory;

    public function __construct(CollectionFactory $pageCollectionFactory)
    {
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    public function toOptionArray()
    {
        $page = $this->pageCollectionFactory->create()->getData();
        $options = [];
        foreach ($page as $rows) {
            $options[] = [
                'label' => $rows['page_name'],
                'value' => $rows['id']
            ];
        }
        return $options;
    }
}

