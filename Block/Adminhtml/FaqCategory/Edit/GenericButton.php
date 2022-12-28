<?php
/**
 * Class GenericButton
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Faq
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Faq\Block\Adminhtml\FaqCategory\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{
    /**
     * Context
     *
     * @var Context
     */
    protected $context;

    /**
     * GenericButton constructor
     *
     * @param Context $context Context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Return Post ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->context->getRequest()->getParam('id');
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route  Route
     * @param array  $params Params
     *
     * @return string url for the button
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
