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
    public function getBadgeId(): ?string
    {
        return $this->getData(self::BADGE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeId($badgeId): \Mucan\Badges\Badge\Api\Data\BadgeInterface
    {
        return $this->setData(self::BADGE_ID, $badgeId);
    }

    /**
     * @inheritDoc
     */
    public function getBadge(): ?string
    {
        return $this->getData(self::BADGE);
    }

    /**
     * @inheritDoc
     */
    public function setBadge($badge): \Mucan\Badges\Badge\Api\Data\BadgeInterface
    {
        return $this->setData(self::BADGE, $badge);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeWidth(): ?string
    {
        return $this->getData(self::BADGE_WIDTH);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeWidth($badge): \Mucan\Badges\Badge\Api\Data\BadgeInterface
    {
        return $this->setData(self::BADGE_WIDTH, $badge);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeHeight($badgeId): \Mucan\Badges\Badge\Api\Data\BadgeInterface
    {
        return $this->setData(self::BADGE_HEIGHT, $badgeId);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeHeight(): ?string
    {
        return $this->getData(self::BADGE_HEIGHT);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeName(): ?string
    {
        return $this->getData(self::BADGE_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeName($badgeName): \Mucan\Badges\Badge\Api\Data\BadgeInterface
    {
        return $this->setData(self::BADGE_NAME, $badgeName);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeColor(): ?string
    {
        return $this->getData(self::BADGE_COLOR);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeColor($badgeColor): \Mucan\Badges\Badge\Api\Data\BadgeInterface
    {
        return $this->setData(self::BADGE_COLOR, $badgeColor);
    }

    /**
     * @inheritDoc
     */
    public function getBadgeImage(): ?string
    {
        return $this->getData(self::BADGE_IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setBadgeImage($badgeImage): \Mucan\Badges\Badge\Api\Data\BadgeInterface
    {
        return $this->setData(self::BADGE_IMAGE, $badgeImage);
    }

    /**
     * @inheritDoc
     */
    public function getImageUrl(): ?string
    {
        return $this->getData(self::IMAGE_URL);
    }
}
