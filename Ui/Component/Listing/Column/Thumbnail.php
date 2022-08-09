<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

/**
 * Copyright © Mucan All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mucan\Badges\Ui\Component\Listing\Column;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Thumbnail
 */
class Thumbnail extends Column
{
    protected StoreManagerInterface $storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * @param array $dataSource
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource): array
    {
        foreach ($dataSource["data"]["items"] as &$item) {
            if (isset($item['badge_image'])) {
                $url = $this->storeManager->getStore()
                        ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $item['badge_image'];
                $item['path_src'] = $url;
                $item['path_alt'] = $item['badge_name'];
                $item['path_link'] = $url;
                $item['path_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}
