<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Api\Data;

/**
 * Interface BadgeSearchResultsInterface
 */
interface BadgeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Badge list.
     * @return \Mucan\Badges\Api\Data\BadgeInterface[]
     */
    public function getItems(): array;

    /**
     * Set badge list.
     * @param \Mucan\Badges\Api\Data\BadgeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
