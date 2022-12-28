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
namespace Risecommerce\Faq\Model;

use Magento\Store\Model\StoreManagerInterface;
use Risecommerce\Faq\Api\Data\FaqInterface as Bi;


class Faq extends \Magento\Framework\Model\AbstractModel implements Bi
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    private $_filterProvider;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Registry $registry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Faq Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Risecommerce\Faq\Model\ResourceModel\Faq');
    }

    /**
     * Get Stores
     *
     * @return array
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : (array)$this->getData('store_id');
    }

    /**
     * Get faq id
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::FAQ_ID);
    }

    /**
     * Set faq id
     *
     * @param int $id Faqid
     *
     * @return void
     */
    public function setId($id)
    {
        return $this->setData(self::FAQ_ID, $id);
    }

    /**
     * Get Faq Answer
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function getFaqAnswer()
    {
        // TODO: Implement getFaqAnswer() method.
        $html = $this->_filterProvider->getPageFilter()->filter($this->getData(self::FAQ_ANSWER));
        return $html;
    }
}
