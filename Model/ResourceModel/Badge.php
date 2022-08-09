<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Badge class
 * Absract resource model for Badge
 */
class Badge extends AbstractDb
{
    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init('mucan_badges_badge', 'badge_id');
    }
}
