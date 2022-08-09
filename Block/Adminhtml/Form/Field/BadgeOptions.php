<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Block\Adminhtml\Form\Field;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Mucan\Badges\Model\ResourceModel\Badge\CollectionFactory;

/**
 * BadgeOptions class
 */
class BadgeOptions extends AbstractSource
{
    protected CollectionFactory $badgeCollection;

    /**
     * Construct
     *
     * @param CollectionFactory $badgeCollection
     */
    public function __construct(CollectionFactory $badgeCollection)
    {
        $this->badgeCollection = $badgeCollection;
    }

    /**
     * @inheritdoc
     */
    public function getAllOptions(): array
    {
        $badges = $this->badgeCollection->create();
        $badgesOptions = [];
        $badgesOptions[] = [
            'value' => '',
            'label' => 'No Badge'
        ];
        foreach ($badges as $badge) {
            $badgesOptions[] = [
                'value' => $badge->getId(),
                'label' => $badge->getBadgeName()
            ];
        }
        return $badgesOptions;
    }
}
