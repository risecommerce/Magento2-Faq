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
namespace Risecommerce\Faq\Block\Widget;

use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use Risecommerce\Faq\Model\ResourceModel\FaqCategory\CollectionFactory as FaqCollectionFactory;
use Risecommerce\Faq\Model\FaqFactory;
use Risecommerce\Faq\Model\FaqCategoryFactory;
use Risecommerce\Faq\Model\ResourceModel\Faq\CollectionFactory;
use Risecommerce\Faq\Helper\Data;
use Magento\Framework\View\Layout;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;


class Faq extends Template implements BlockInterface
{
    /**
     * FaqFactory
     *
     * @var \Risecommerce\Faq\Model\FaqFactory
     */
    protected $faqFactory;

    /**
     * FaqCategoryFactory
     *
     * @var FaqCategoryFactory
     */
    protected $faqCategoryFactory;

    /**
     * FaqCollectionFactory
     *
     * @var CollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * FaqCategoryCollectionFactory
     *
     * @var FaqCollectionFactory
     */
    protected $faqitemCollectionFactory;

    /**
     * RisecommerceFaq Helper
     *
     * @var Data
     */
    protected $helperData;

    /**
     * ResultPage
     *
     * @var Page
     */
    protected $pageResult;

    /**
     * Layout
     *
     * @var Layout
     */
    protected $layout;

    /**
     * Items
     *
     * @var items
     */
    protected $items;

    /**
     * Request
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * Faq constructor.
     *
     * @param Context              $context                  context
     * @param FaqFactory           $faqFactory               faqFactory
     * @param FaqCategoryFactory   $faqCategoryFactory       faqCategoryFactory
     * @param CollectionFactory    $itemCollectionFactory    itemCollectionFactory
     * @param FaqCollectionFactory $faqitemCollectionFactory faqitemCollectionFactory
     * @param Data                 $helperData               helperData
     * @param Layout               $layout                   layout
     * @param Page                 $pageResult               pageResult
     * @param RequestInterface     $request                  request
     * @param array                $data                     data
     */
    public function __construct(
        Context $context,
        FaqFactory $faqFactory,
        FaqCategoryFactory $faqCategoryFactory,
        CollectionFactory $itemCollectionFactory,
        FaqCollectionFactory $faqitemCollectionFactory,
        Data $helperData,
        Layout $layout,
        Page $pageResult,
        RequestInterface $request,
        array $data = []
    ) {
        $this->faqFactory = $faqFactory;
        $this->faqCategoryFactory = $faqCategoryFactory;
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->faqitemCollectionFactory = $faqitemCollectionFactory;
        $this->helperData = $helperData;
        $this->pageResult = $pageResult;
        $this->layout = $layout;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    /**
     * Get Faq Items
     *
     * @return \Risecommerce\Faq\Model\ResourceModel\Faq\Collection
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getFaqItems()
    {
        $faqCatId = $this->request->getParam('id') ? $this->request->getParam('id') : 1;
        if (!$this->items) {
            if (!$this->isCategoryNavbarEnable()) {
                $this->items = $this->itemCollectionFactory->create()
                    ->addFieldToSelect(
                        '*'
                    )->addFieldToFilter(
                        'is_active',
                        ['eq' => \Risecommerce\Faq\Model\Faq::STATUS_ENABLED]
                    )
                    ->addStoreFilter($this->_storeManager->getStore()->getId())
                    ->addOrder('sort_order', 'asc')
                    ->addOrder('creation_time', 'desc');
            } else {
                $this->items = $this->itemCollectionFactory->create()
                    ->addFieldToSelect(
                        '*'
                    )->addFieldToFilter(
                        'is_active',
                        ['eq' => \Risecommerce\Faq\Model\Faq::STATUS_ENABLED]
                    )->addFieldToFilter(
                        'faq_category_id',
                        $faqCatId
                    )
                    ->addStoreFilter($this->_storeManager->getStore()->getId())
                    ->addOrder('sort_order', 'asc')
                    ->addOrder('creation_time', 'desc');
            }
        }
        return $this->items;
    }

    /**
     * Get Faq is enabled or disabled
     *
     * @return string
     */
    public function isFaqEnabled()
    {
        return $this->helperData->getGeneralConfig('enable');
    }

    /**
     * Get Category Label Text
     *
     * @return string
     */
    public function getFaqListLabelText()
    {
        return $this->helperData->getFaqListConfig('faq_list_label_text');
    }

    /**
     * @return items|\Risecommerce\Faq\Model\ResourceModel\FaqCategory\Collection
     */
    public function getFaqCategoryItems()
    {
        if (!$this->items) {
            $this->items = $this->faqitemCollectionFactory->create()
                ->addFieldToSelect(
                    '*'
                )->addFieldToFilter(
                    'is_active',
                    ['eq' => \Risecommerce\Faq\Model\FaqCategory::STATUS_ENABLED]
                )->addOrder(
                    'sort_order',
                    'asc'
                )->addOrder(
                    'faq_category_name',
                    'asc'
                );
        }
        return $this->items;
    }

    /**
     * Is Category Navbar Enable
     *
     * @return boolean
     */
    public function isCategoryNavbarEnable()
    {
        return $this->helperData->getGeneralConfig('is_category_navbar_enable');
    }

    /**
     * Will return the currect page layout.
     *
     * @return string The current page layout.
     */
    public function getCurrentPageLayout()
    {
        $currentPageLayout = $this->pageResult->getConfig()->getPageLayout();

        if ($currentPageLayout === null) {
            return $this->layout->getUpdate()->getPageLayout();
        }

        return $currentPageLayout;
    }

    /**
     * Return Current Faq Id from request
     *
     * @return int
     */
    function getCurrentFaqCatId()
    {
        return $this->request->getParam('id');
    }
}
