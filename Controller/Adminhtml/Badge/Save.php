<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Controller\Adminhtml\Badge;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Mucan\Badges\Model\Badge;

/**
 * Class Save
 * Controller for saving badge
 */
class Save extends Action
{
    protected DataPersistorInterface $dataPersistor;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param Database $coreStorage
     * @throws FileSystemException
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        Database $coreStorage,
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->uploaderFactory = $uploaderFactory;
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->coreStorage = $coreStorage;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $badgeId = $this->getRequest()->getParam('badge_id');

            $model = $this->_objectManager->create(Badge::class)->load($badgeId);
            if (!$model->getId() && $badgeId) {
                $this->messageManager->addErrorMessage(__('This Badge no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $data = $this->getRequestImage($data);

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Badge.'));
                $this->dataPersistor->clear('mucan_badges_badge');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['badge_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, $e->getMessage());
            }

            $this->dataPersistor->set('mucan_badges_badge', $data);
            return $resultRedirect->setPath('*/*/edit', ['badge_id' => $this->getRequest()->getParam('badge_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param array $params
     * @return array
     * @throws LocalizedException
     */
    private function getRequestImage(array $params): array
    {
        if (isset($params['badge_image']) && is_array($params['badge_image'])) {
            $imageId = $params['badge_image'][0];
            if (!file_exists($imageId['tmp_name'])) {
                $imageId['tmp_name'] = $imageId['path'] . '/' . $imageId['file'];
                $params['badge_image'] = $this->moveFileFromTmp($imageId);
            }
        }
        return $params;
    }

    /**
     * @param string $imageId
     * @return string
     * @throws LocalizedException
     */
    private function moveFileFromTmp(string $imageId): string
    {
        $baseTmpImagePath = $imageId['tmp_name'];
        $type = explode("/", $imageId['type'])[1];
        $baseImagePath = $this->mediaDirectory->getRelativePath('mucan/badges/' .  uniqid() . '.' . $type);
        try {
            $this->coreStorage->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (Exception $e) {
            throw new LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }
        return $baseImagePath;
    }
}
