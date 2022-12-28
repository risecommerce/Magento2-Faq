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
namespace Risecommerce\Faq\Model\ResourceModel\Faq;

use Risecommerce\Faq\Api\Data\FaqInterface;
use Risecommerce\Faq\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Primary fieldname
     *
     * @var string
     */
    protected $_idFieldName = 'faq_id';

    /**
     * Load data for preview flag
     *
     * @var bool
     */
    protected $_previewFlag;

    /**
     * Collection Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Risecommerce\Faq\Model\Faq',
            'Risecommerce\Faq\Model\ResourceModel\Faq'
        );
        $this->_map['fields']['faq_id'] = 'main_table.faq_id';
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store     storeid
     * @param bool                                 $withAdmin isadmin
     *
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }
        return $this;
    }

    /**
     * Set first store flag
     *
     * @param bool $flag flag
     *
     * @return $this
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(FaqInterface::class);
        $this->performAfterLoad('risecommerce_faq_store', $entityMetadata->getLinkField());
        $this->performAfterLoadFaqCategory('risecommerce_faq_category', "faq_category_id");
        $this->_previewFlag = false;

        return parent::_afterLoad();
    }

    /**
     * Perform operations before rendering filters
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(FaqInterface::class);
        $this->joinStoreRelationTable('risecommerce_faq_store', $entityMetadata->getLinkField());
    }
}
