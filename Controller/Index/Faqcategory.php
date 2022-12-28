<?php
/**
 * Class Faqcategory
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Controller\Index;

use Risecommerce\Faq\Helper\Data;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Result\PageFactory;


class Faqcategory extends \Magento\Framework\App\Action\Action
{
    /**
     * PageFactory
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * ResultJsonFactory
     *
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * HelperData
     *
     * @var Data
     */
    protected $helperData;

    /**
     * Faq constructor.
     *
     * @param Context     $context           context
     * @param PageFactory $resultPageFactory resultPageFactory
     * @param JsonFactory $resultJsonFactory resultJsonFactory
     * @param Data        $helperData        helperData
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        Data $helperData
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    /**
     * Faq action execute
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create(ResultFactory::TYPE_PAGE);
        $result = $this->resultJsonFactory->create();
        $block = $resultPage->getLayout()
            ->createBlock('Risecommerce\Faq\Block\Widget\Faq')
            ->setTemplate('Risecommerce_Faq::widget/faqcategory.phtml')
            ->toHtml();

        $result->setData(['output' => $block]);
        return $result;
    }
}
