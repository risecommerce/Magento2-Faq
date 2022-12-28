<?php
/**
 * Class Delete
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Controller\Adminhtml\Faqbackend;

use Magento\Backend\App\Action;


class Delete extends \Magento\Backend\App\Action
{
    /**
     * Admin Resource
     *
     * @param string
     */
    const ADMIN_RESOURCE = 'Risecommerce_Faq::risecommerce_faq';

    /**
     * Faq Model
     *
     * @param \Risecommerce\Faq\Model\Faq
     */
    protected $model;

    /**
     * Faq ResourceModel
     *
     * @param \Risecommerce\Faq\Model\ResourceModel\Faq
     */
    protected $faqResource;

    /**
     * Delete constructor
     *
     * @param Action\Context                          $context     context
     * @param \Risecommerce\Faq\Model\Faq               $model       $model Faqmodel
     * @param \Risecommerce\Faq\Model\ResourceModel\Faq $faqResource faqResource
     */
    public function __construct(
        Action\Context $context,
        \Risecommerce\Faq\Model\FaqFactory $model,
        \Risecommerce\Faq\Model\ResourceModel\Faq $faqResource
    ) {
        $this->model = $model;
        $this->faqResource = $faqResource;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return $this
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $faqModel = $this->model->create();
                $this->faqResource->load($faqModel, $id);
                $this->faqResource->delete($faqModel);
                $this->messageManager->addSuccessMessage(
                    __('FAQ has been deleted.')
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(
            __('We can\'t find FAQ to delete.')
        );
        return $resultRedirect->setPath('*/*/');
    }
}
