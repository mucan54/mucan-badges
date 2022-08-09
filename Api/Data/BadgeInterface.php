<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Api\Data;

/**
 * Interface BadgeInterface
 */
interface BadgeInterface
{
    const BADGE = 'badge';
    const BADGE_ID = 'badge_id';
    const BADGE_WIDTH = 'badge_width';
    const BADGE_HEIGHT = 'badge_height';
    const BADGE_NAME = 'badge_name';
    const BADGE_COLOR = 'badge_color';
    const BADGE_IMAGE = 'badge_image';

    /**
     * Get badge_id
     * @return string|null
     */
    public function getBadgeId(): ?string;

    /**
     * Set badge_id
     * @param string $badgeId
     * @return \Mucan\Badges\Badge\Api\Data\BadgeInterface
     */
    public function setBadgeId(string $badgeId): \Mucan\Badges\Badge\Api\Data\BadgeInterface;

    /**
     * Get badge_width
     * @return string|null
     */
    public function getBadgeWidth(): ?string;

    /**
     * Set badge_width
     * @param string $badgeId
     * @return \Mucan\Badges\Badge\Api\Data\BadgeInterface
     */
    public function setBadgeWidth(string $badgeId): \Mucan\Badges\Badge\Api\Data\BadgeInterface;

    /**
     * Get badge_height
     * @return string|null
     */
    public function getBadgeHeight(): ?string;

    /**
     * Set badge_height
     * @param string $badgeId
     * @return \Mucan\Badges\Badge\Api\Data\BadgeInterface
     */
    public function setBadgeHeight(string $badgeId): \Mucan\Badges\Badge\Api\Data\BadgeInterface;

    /**
     * Get badge
     * @return string|null
     */
    public function getBadge(): ?string;

    /**
     * Set badge
     * @param string $badge
     * @return \Mucan\Badges\Badge\Api\Data\BadgeInterface
     */
    public function setBadge(string $badge): \Mucan\Badges\Badge\Api\Data\BadgeInterface;

    /**
     * Get badge_name
     * @return string|null
     */
    public function getBadgeName(): ?string;

    /**
     * Set badge_name
     * @param string $badgeName
     * @return \Mucan\Badges\Badge\Api\Data\BadgeInterface
     */
    public function setBadgeName(string $badgeName): \Mucan\Badges\Badge\Api\Data\BadgeInterface;

    /**
     * Get badge_color
     * @return string|null
     */
    public function getBadgeColor(): ?string;

    /**
     * Set badge_color
     * @param string $badgeColor
     * @return \Mucan\Badges\Badge\Api\Data\BadgeInterface
     */
    public function setBadgeColor(string $badgeColor): \Mucan\Badges\Badge\Api\Data\BadgeInterface;

    /**
     * Get badge_image
     * @return string|null
     */
    public function getBadgeImage(): ?string;

    /**
     * Set badge_image
     * @param string $badgeImage
     * @return \Mucan\Badges\Badge\Api\Data\BadgeInterface
     */
    public function setBadgeImage(string $badgeImage): \Mucan\Badges\Badge\Api\Data\BadgeInterface;
}
