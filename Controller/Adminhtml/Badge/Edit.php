<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Controller\Adminhtml\Badge;

/**
 * Class Edit
 * Edit badge controller
 */
class Edit extends \Mucan\Badges\Controller\Adminhtml\Badge
{
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(): \Magento\Framework\Controller\ResultInterface
    {
        // 1. Get ID and create model
        $badgeId = $this->getRequest()->getParam('badge_id');
        $model = $this->_objectManager->create(\Mucan\Badges\Model\Badge::class);

        // 2. Initial checking
        if ($badgeId) {
            $model->load($badgeId);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Badge no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('mucan_badges_badge', $model);

        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $badgeId ? __('Edit Badge') : __('New Badge'),
            $badgeId ? __('Edit Badge') : __('New Badge')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Badges'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Badge %1', $model->getId()) : __('New Badge'));
        return $resultPage;
    }
}
