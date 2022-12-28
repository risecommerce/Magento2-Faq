<?php
/**
 * Class MassDelete
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

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Risecommerce\Faq\Model\ResourceModel\FaqCategory\CollectionFactory;
use Risecommerce\Faq\Model\ResourceModel\Faq\CollectionFactory as FaqCollectionFactory;


class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Admin Resource
     *
     * @param string
     */
    const ADMIN_RESOURCE = 'Risecommerce_Faq::risecommerce_faq_category';
    
    /**
     * Filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * FaqcategoryCollectionFactory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * FaqCollectionFactory
     *
     * @var FaqCollectionFactory
     */
    protected $faqFactory;

    /**
     * MassDelete constructor.
     *
     * @param Context              $context           context
     * @param Filter               $filter            filter
     * @param FaqCollectionFactory $faqFactory        faqFactory
     * @param CollectionFactory    $collectionFactory collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        FaqCollectionFactory $faqFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->faqFactory = $faqFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     *
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        foreach ($collection as $item) {
            if ($item ['faq_category_id'] == 1) {
                $this->messageManager->addErrorMessage(
                    __('Default FAQ Category cannot be deleted.')
                );
                return $resultRedirect->setPath('*/*/');
            }
        }

        foreach ($collection as $item) {
            $id = $item->getId();
            $faqCollection = $this->faqFactory->create()
                ->addFieldToFilter('faq_category_id', $id);
            if (!empty($faqCollection)) {
                $faqCollection->setDataToAll('faq_category_id', null);
                $faqCollection->save();
            }
            $item->delete();
        }
        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', $collectionSize)
        );
        return $resultRedirect->setPath('*/*/');
    }
}
