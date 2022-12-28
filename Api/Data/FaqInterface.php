<?php
/**
 * Interface FaqInterface
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Api\Data;

interface FaqInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const FAQ_ID          = 'faq_id';
    const FAQ_ANSWER          = 'faq_answer';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id set faq id
     *
     * @return \Risecommerce\Faq\Api\Data\FaqInterface
     */
    public function setId($id);

    /**
     * Get Stores
     *
     * @return array
     */
    public function getStores();

    /**
     * @return mixed
     */
    public function getFaqAnswer();
}
