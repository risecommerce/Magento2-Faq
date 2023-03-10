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
namespace Risecommerce\Faq\Controller\Adminhtml\Faqbackend;

use Risecommerce\Faq\Model\FaqFactory;
use Risecommerce\Faq\Model\ResourceModel\Faq as FaqResource;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;


class Save extends \Risecommerce\Faq\Controller\Adminhtml\Faq
{
    /**
     * Admin Resource
     *
     * @param string
     */
    const ADMIN_RESOURCE = 'Risecommerce_Faq::risecommerce_faq';

    /**
     * Data Processor
     *
     * @var \Risecommerce\Faq\Controller\Adminhtml\Faqbackend\PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * Data Persostor
     *
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Faq Model
     *
     * @var \Risecommerce\Faq\Model\FaqFactory
     */
    protected $model;

    /**
     * Faq Resource Model
     *
     * @var \Risecommerce\Faq\Model\ResourceModel\Faq
     */
    protected $faqResource;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param FaqFactory $model
     * @param FaqResource $faqResource
     * @param DataPersistorInterface $dataPersistor
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PostDataProcessor $dataProcessor,
        FaqFactory $model,
        FaqResource $faqResource,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->model = $model;
        $this->faqResource = $faqResource;
        $this->date = $date;
        parent::__construct($context, $model);
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
                $this->dataPersistor->set('faqdata', $data);
                return $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        'id' => $this->model->getId(),
                        '_current' => true
                    ]
                );
            }
            
            try {
                $data['store_id'] = json_encode($data['store_id']);
                $data['update_time'] =  $this->date->gmtDate();

                $faqModel = $this->model->create()->setData($data);
                $this->faqResource->save($faqModel);

                $this->messageManager->addSuccessMessage(
                    __('FAQ is saved successfully.')
                );
                $this->dataPersistor->clear('faqdata');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            'id' => $faqModel->getId(),
                            '_current' => true
                        ]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the Faq.')
                );
            }

            $this->dataPersistor->set('faqdata', $data);
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $faqModel->getId()
                ]
            );
        }
        return $resultRedirect->setPath('*/*/');
    }
}
