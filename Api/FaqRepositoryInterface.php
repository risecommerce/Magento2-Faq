<?php
/**
 * Interface FaqRepositoryInterface
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Api;

use Risecommerce\Faq\Api\Data\FaqInterface;

interface FaqRepositoryInterface
{
    /**
     * Save Data
     *
     * @param object $faq object
     *
     * @return \Risecommerce\Faq\Api\Data\FaqInterface
     **/
    public function save(FaqInterface $faq);

    /**
     * Get Data By Id
     *
     * @param int $id Load Data by Id
     *
     * @return \Risecommerce\Faq\Api\Data\FaqInterface
     **/
    public function getById($id);

    /**
     * Delete Object Data
     *
     * @param object $faq Object
     *
     * @return \Risecommerce\Faq\Api\Data\FaqInterface
     **/
    public function delete(FaqInterface $faq);

    /**
     * Delete Data By ID
     *
     * @param int $id Delete Object By Id
     *
     * @return \Risecommerce\Faq\Api\Data\FaqInterface
     **/
    public function deleteById($id);
}
