<?php
/**
 * Class Index
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Controller\Adminhtml\FaqCategoryBackend;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;


class Index extends \Magento\Backend\App\Action
{
    /**
     * Admin Resource
     *
     * @param string
     */
    const ADMIN_RESOURCE = 'Risecommerce_Faq::risecommerce_faq_category';

    /**
     * Context
     *
     * @var Context
     */
    protected $context;

    /**
     * ResultPageFactory
     *
     * @var PageFactory
     */
    protected $resultPageFactory = false;

    /**
     * Index constructor.
     *
     * @param Context     $context           context
     * @param PageFactory $resultPageFactory resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->context = $context;
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Risecommerce_Faq::risecommerce_faq_category');
        $resultPage->getConfig()->getTitle()->prepend((__('Manage Faq Category')));

        return $resultPage;
    }
}
