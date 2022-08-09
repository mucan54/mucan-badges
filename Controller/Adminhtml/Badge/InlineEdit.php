<?php

/**
 * Mucan Package
 *
 * @copyright Mucan (https://github.com/mucan54)
 */

declare(strict_types=1);

namespace Mucan\Badges\Controller\Adminhtml\Badge;

use Magento\Framework\Controller\ResultInterface;

/**
 * Class InlineEdit
 * Controller for inline edit of badge
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    protected $jsonFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context              $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Inline edit action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            foreach (array_keys($postItems) as $modelid) {
                /** @var \Mucan\Badges\Model\Badge $model */
                $model = $this->_objectManager->create(\Mucan\Badges\Model\Badge::class)->load($modelid);
                try {
                    $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                    $model->save();
                } catch (\Exception $e) {
                    $messages[] = "[Badge ID: {$modelid}]  {$e->getMessage()}";
                    $error = true;
                }
            }
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
