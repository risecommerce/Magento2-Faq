<?php
/**
 * Class Save
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

use Risecommerce\Faq\Model\FaqCategoryFactory;
use Risecommerce\Faq\Model\ResourceModel\FaqCategory as FaqCategoryResource;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;


class Save extends \Magento\Backend\App\Action
{
    /**
     * Admin Resource
     *
     * @param string
     */
    const ADMIN_RESOURCE = 'Risecommerce_Faq::risecommerce_faq_category';

    /**
     * DataProcessor
     *
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * DataPersistor
     *
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * FaqCategory Model
     *
     * @var FaqCategoryFactory
     */
    protected $model;

    /**
     * FaqCategory Resource Model
     *
     * @var FaqCategoryResource
     */
    protected $faqCategoryResource;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * Save constructor.
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param FaqCategoryFactory $model
     * @param FaqCategoryResource $faqCategoryResource
     * @param DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        FaqCategoryFactory $model,
        FaqCategoryResource $faqCategoryResource,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->model = $model;
        $this->faqCategoryResource = $faqCategoryResource;
        $this->date = $date;
        parent::__construct($context);
    }

    /**
     * Save action execute
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (!$this->dataProcessor->validate($data)) {
                $this->dataPersistor->set('faqcategorydata', $data);
                if (!empty($data['faq_category_id'])) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            'id' => $data['faq_category_id'],
                            '_current' => true
                        ]
                    );
                } else {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            '_current' => true
                        ]
                    );
                }
            }

            try {
                $data['update_time'] =  $this->date->gmtDate();
                $faqcategoryModel = $this->model->create()->setData($data);

                if (isset($data['faq_category_id']) && $data['faq_category_id'] == 1 && $data['is_active'] != 1) {
                    $this->messageManager->addErrorMessage(
                        __('Default FAQ Category cannot be disabled.')
                    );
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            'id' => $data['faq_category_id'],
                            '_current' => true
                        ]
                    );
                } else {

                    $this->faqCategoryResource->save($faqcategoryModel);

                    $this->messageManager->addSuccessMessage(
                        __('FAQ Category is saved successfully.')
                    );
                    $this->dataPersistor->clear('faqcategorydata');
                    if ($this->getRequest()->getParam('back')) {
                        if (!empty($data['faq_category_id'])) {

                            return $resultRedirect->setPath(
                                '*/*/edit',
                                [
                                    'id' => $data['faq_category_id'],
                                    '_current' => true
                                ]
                            );
                        } else {
                            return $resultRedirect->setPath(
                                '*/*/edit',
                                [
                                    '_current' => true
                                ]
                            );
                        }
                    }
                    return $resultRedirect->setPath('*/*/');
                }

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(
                    $e->getMessage()
                );
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the faq category.')
                );
            }

            $this->dataPersistor->set('faqcategorydata', $data);
            if (!empty($data['faq_category_id'])) {
                return $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        'id' => $data['faq_category_id']
                    ]
                );
            } else {
                return $resultRedirect->setPath('*/*/edit');
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
