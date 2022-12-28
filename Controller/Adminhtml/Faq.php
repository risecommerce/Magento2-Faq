<?php
/**
 * Class Faq
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Controller\Adminhtml;

abstract class Faq extends \Magento\Backend\App\Action
{
    /**
     * Faq Model
     *
     * @param \Risecommerce\Faq\Model\Faq
     */
    protected $model;

    /**
     * Faq constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Risecommerce\Faq\Model\FaqFactory $model
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Risecommerce\Faq\Model\FaqFactory $model
    ) {
        $this->model = $model;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage Resultpage
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Risecommerce_Faq::risecommerce_faq')
            ->addBreadcrumb(__('FAQ'), __('FAQ'))
            ->addBreadcrumb(__('Items'), __(''));
        return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Risecommerce_Faq::risecommerce_faq');
    }

    /**
     * InitAttachment
     *
     * @return mixed Attachnebtobject
     */
    protected function initFaqData()
    {
        $faqId = (int)$this->getRequest()->getParam('id');

        $faqId = $faqId ? $faqId : (int)$this->getRequest()->getParam('faq_id');

        $faqModel = $this->model->create();

        if ($faqId) {
            $faqModel->load($faqId);
        }

        return $faqModel;
    }
}
