<?php
/**
 * Class Collection
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Model\ResourceModel\FaqCategory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    protected $_idFieldName = 'faq_category_id';
    protected $_eventPrefix = 'risecommerce_faq_category_collection';
    protected $_eventObject = 'faq_category_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Risecommerce\Faq\Model\FaqCategory',
            'Risecommerce\Faq\Model\ResourceModel\FaqCategory'
        );
    }
}
