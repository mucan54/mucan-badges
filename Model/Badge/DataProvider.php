<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Model\Badge;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Mucan\Badges\Model\ResourceModel\Badge\CollectionFactory;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    protected $collection;

    protected DataPersistorInterface $dataPersistor;

    protected array $loadedData;

    protected StoreManagerInterface $storeManager;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
            $imageData = [];
            if ($model->getBadgeImage()) {
                $imageData['badge_image'][0]['name'] = $model->getBadgeImage();
                $imageData['badge_image'][0]['url'] = $this->getMediaUrl($model->getBadgeImage());
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $imageData);
            }
        }
        $data = $this->dataPersistor->get('mucan_badges_badge');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('mucan_badges_badge');
        }

        return $this->loadedData;
    }

    /**
     * @param string $path
     * @return string
     * @throws NoSuchEntityException
     */
    private function getMediaUrl(string $path): string
    {
        return $this->storeManager
                ->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . '/' . $path;
    }
}
