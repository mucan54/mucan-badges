<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mucan\Badges\Api\BadgeRepositoryInterface;
use Mucan\Badges\Api\Data\BadgeInterface;
use Mucan\Badges\Api\Data\BadgeInterfaceFactory;
use Mucan\Badges\Api\Data\BadgeSearchResultsInterfaceFactory;
use Mucan\Badges\Model\ResourceModel\Badge as ResourceBadge;
use Mucan\Badges\Model\ResourceModel\Badge\CollectionFactory as BadgeCollectionFactory;

/**
 * Class BadgeRepository
 * Badge repository
 */
class BadgeRepository implements BadgeRepositoryInterface
{
    protected ResourceBadge $resource;

    protected BadgeInterfaceFactory $badgeFactory;

    protected BadgeCollectionFactory $badgeCollection;

    protected Badge $searchResultsFactory;

    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @param ResourceBadge $resource
     * @param BadgeInterfaceFactory $badgeFactory
     * @param BadgeCollectionFactory $badgeCollection
     * @param BadgeSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceBadge $resource,
        BadgeInterfaceFactory $badgeFactory,
        BadgeCollectionFactory $badgeCollection,
        BadgeSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->badgeFactory = $badgeFactory;
        $this->badgeCollection = $badgeCollection;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(BadgeInterface $badge)
    {
        try {
            $this->resource->save($badge);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the badge: %1',
                $exception->getMessage()
            ));
        }
        return $badge;
    }

    /**
     * @inheritDoc
     */
    public function get($badgeId)
    {
        $badge = $this->badgeFactory->create();
        $this->resource->load($badge, $badgeId);
        if (!$badge->getId()) {
            throw new NoSuchEntityException(__('Badge with id "%1" does not exist.', $badgeId));
        }
        return $badge;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->badgeCollection->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(BadgeInterface $badge)
    {
        try {
            $badgeModel = $this->badgeFactory->create();
            $this->resource->load($badgeModel, $badge->getBadgeId());
            $this->resource->delete($badgeModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Badge: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($badgeId)
    {
        return $this->delete($this->get($badgeId));
    }
}
