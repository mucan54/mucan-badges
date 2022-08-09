<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Plugins;

use Closure;
use Magento\Catalog\Block\Product\Image as ImageBlock;
use Magento\Catalog\Block\Product\ImageFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mucan\Badges\Model\BadgeRepository;

/**
 * Class ImageFactoryPlugin
 */
class ImageFactoryPlugin
{
    private BadgeRepository $badgeRepository;

    private ProductFactory $product;

    private StoreManagerInterface $storeManager;

    /**
     * @param BadgeRepository $badgeRepository
     * @param ProductFactory $product
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(BadgeRepository $badgeRepository, ProductFactory $product, StoreManagerInterface $storeManager)
    {
        $this->badgeRepository = $badgeRepository;
        $this->product = $product;
        $this->storeManager = $storeManager;
    }

    /**
     * @param ImageFactory $subject
     * @param Closure $proceed
     * @param Product $product
     * @param string $imageId
     * @param array|null $attributes
     * @return mixed
     * @throws LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundCreate(
        ImageFactory $subject,
        Closure $proceed,
        Product $product,
        string $imageId,
        array $attributes = null
    ) {
        $badgeId = $this->product->create()->load($product->getId())->getBadge();
        if (!$badgeId) {
            return $proceed($product, $imageId, $attributes);
        }
        $badge = $this->badgeRepository->get($badgeId);
        /** @var ImageBlock $newTemplate */
        $newTemplate = $proceed($product, $imageId, $attributes);
        $newTemplate->setTemplate('Mucan_Badges::product/image_with_borders.phtml');
        $newTemplate->setData('badge_name', $badge->getBadgeName());
        $newTemplate->setData('badge_text', $badge->getBadgeName());
        $newTemplate->setData('badge_color', $badge->getBadgeColor());
        $newTemplate->setData('badge_image', $this->getMediaUrl($badge->getBadgeImage()));

        return $newTemplate;
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
