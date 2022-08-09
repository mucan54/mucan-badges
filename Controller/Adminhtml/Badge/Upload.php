<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Controller\Adminhtml\Badge;

use Exception;
use Filesystem\Directory\WriteInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Upload
 * Controller for uploading badge image
 */
class Upload extends \Magento\Backend\App\Action
{
    protected UploaderFactory $uploaderFactory;

    protected WriteInterface $mediaDirectory;

    protected StoreManagerInterface $storeManager;

    /**
     * Constructor
     *
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Context $context,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->uploaderFactory = $uploaderFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->storeManager = $storeManager;
    }

    /**
     * Upload file controller action
     *
     * @return Json
     */
    public function execute(): Json
    {
        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        try {
            $fileUploader = $this->uploaderFactory->create(['fileId' => 'badge_image']);
            $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
            $fileUploader->setAllowRenameFiles(true);
            $fileUploader->setAllowCreateFolders(true);
            $fileUploader->setFilesDispersion(false);
            $result = $fileUploader->save($this->mediaDirectory->getAbsolutePath('tmp/badges/images'));
            $result['url'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                . 'tmp/badges/images/' . ltrim(str_replace('\\', '/', $result['file']), '/');
            return $jsonResult->setData($result);
        } catch (LocalizedException $e) {
            return $jsonResult->setData(['errorcode' => 0, 'error' => $e->getMessage()]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            return $jsonResult->setData(['errorcode' => 0, 'error' => $e->getMessage()]);
        }
    }
}
