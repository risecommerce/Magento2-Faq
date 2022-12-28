<?php
/**
 * Class DataProvider
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Model\Faq;

use Risecommerce\Faq\Model\ResourceModel\Faq\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;


class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * Collection
     *
     * @var \Magento\Cms\Model\ResourceModel\Block\Collection
     */
    protected $collection;

    /**
     * Data Persistor
     *
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Loaddata
     *
     * @var array
     */
    protected $loadedData;

    /**
     * Storemanager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    public $storeManager;

    /**
     * Constructor DataProvider
     *
     * @param string                 $name                 name
     * @param string                 $primaryFieldName     Primaryfieldname
     * @param string                 $requestFieldName     Requestfieldname
     * @param CollectionFactory      $faqCollectionFactory faqCollectionFactory
     * @param StoreManagerInterface  $storeManager         StoreManager
     * @param DataPersistorInterface $dataPersistor        DataPersistor
     * @param array                  $meta                 Meta
     * @param array                  $data                 Data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $faqCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $faqCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager=$storeManager;
        
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $model) {
            $this->loadedData[$model->getId()] = $model->getData();
        }

        $data = $this->dataPersistor->get('faqdata');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('faqdata');
        }

        return $this->loadedData;
    }
}
