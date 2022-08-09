<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Model\ResourceModel\Badge;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Badge collection
 * @SuppressWarnings(PHPMD)
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'badge_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Mucan\Badges\Model\Badge::class,
            \Mucan\Badges\Model\ResourceModel\Badge::class
        );
    }
}
