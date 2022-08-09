<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Model;

use Magento\Framework\Model\AbstractModel;
use Mucan\Badges\Api\Data\BadgeInterface;

/**
 * Badge class
 * Badge Model
 */
class Badge extends AbstractModel implements BadgeInterface
{
    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function _construct()
    {
        $this->_init(\Mucan\Badges\Model\ResourceModel\Badge::class);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeId()
    {
        return $this->getData(self::BADGE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeId($badgeId)
    {
        return $this->setData(self::BADGE_ID, $badgeId);
    }

    /**
     * @inheritDoc
     */
    public function getBadge()
    {
        return $this->getData(self::BADGE);
    }

    /**
     * @inheritDoc
     */
    public function setBadge($badge)
    {
        return $this->setData(self::BADGE, $badge);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeName()
    {
        return $this->getData(self::BADGE_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeName($badgeName)
    {
        return $this->setData(self::BADGE_NAME, $badgeName);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeColor()
    {
        return $this->getData(self::BADGE_COLOR);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeColor($badgeColor)
    {
        return $this->setData(self::BADGE_COLOR, $badgeColor);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeImage()
    {
        return $this->getData(self::BADGE_IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeImage($badgeImage)
    {
        return $this->setData(self::BADGE_IMAGE, $badgeImage);
    }

    /**
     * @inheritDoc
     */
    public function getImageUrl()
    {
        return $this->getData(self::IMAGE_URL);
    }
}
