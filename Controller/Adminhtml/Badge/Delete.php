<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Controller\Adminhtml\Badge;

use Exception;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Mucan\Badges\Controller\Adminhtml\Badge as AbstractBadge;
use Mucan\Badges\Model\Badge;

/**
 * Class Delete
 * Delete Controller for badge
 */
class Delete extends AbstractBadge
{
    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $badgeId = $this->getRequest()->getParam('badge_id');
        if ($badgeId) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(Badge::class);
                $model->load($badgeId);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Badge.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['badge_id' => $badgeId]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Badge to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
