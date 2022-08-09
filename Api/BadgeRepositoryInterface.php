<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Api;

/**
 * Interface BadgeRepositoryInterface
 */
interface BadgeRepositoryInterface
{
    /**
     * Save Badge
     * @param \Mucan\Badges\Api\Data\BadgeInterface $badge
     * @return \Mucan\Badges\Api\Data\BadgeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Mucan\Badges\Api\Data\BadgeInterface $badge
    ): \Mucan\Badges\Api\Data\BadgeInterface;

    /**
     * Retrieve Badge
     * @param string $badgeId
     * @return \Mucan\Badges\Api\Data\BadgeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get(string $badgeId): \Mucan\Badges\Api\Data\BadgeInterface;

    /**
     * Retrieve Badge matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mucan\Badges\Api\Data\BadgeSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): \Mucan\Badges\Api\Data\BadgeSearchResultsInterface;

    /**
     * Delete Badge
     * @param \Mucan\Badges\Api\Data\BadgeInterface $badge
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Mucan\Badges\Api\Data\BadgeInterface $badge
    ): bool;

    /**
     * Delete Badge by ID
     * @param string $badgeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(string $badgeId): bool;
}
