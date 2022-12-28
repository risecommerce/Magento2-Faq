<?php
/**
 * Class NewAction
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

class NewAction extends \Risecommerce\Faq\Controller\Adminhtml\Faq
{
    /**
     * Faq Model
     *
     * @param \Risecommerce\Faq\Model\Faq
     */
    protected $model;

    /**
     * ResultPageFactory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * NewAction constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Risecommerce\Faq\Model\FaqFactory $model
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Risecommerce\Faq\Model\FaqFactory $model,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->model = $model;
        parent::__construct($context, $model);
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->getConfig()->getTitle()->prepend(__('Add New FAQ'));
        $resultPage->setActiveMenu('Magento_Backend::faq_settings');
        return $resultPage;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage resultpage
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
         $resultPage->setActiveMenu('Risecommerce_Faq::faq')
             ->addBreadcrumb(__('FAQ'), __('Manage FAQ'))
             ->addBreadcrumb(__('FAQ'), __('Manage FAQ'));

         return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Risecommerce_Faq::faq');
    }
}
