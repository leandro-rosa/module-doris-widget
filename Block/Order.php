<?php
/**
 * Leandro Rosa
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Doris Module to newer
 * versions in the future. If you wish to customize it for your
 * needs please refer to https://developer.adobe.com/commerce/docs/ for more information.
 *
 * @category LeandroRosa
 *
 * @copyright Copyright (c) 2024 Leandro Rosa (https:www.rosa-planet.com.br)
 *
 * @author Leandro Rosa <dev.leandrorosa@gmail.com>
 */
declare(strict_types=1);

namespace LeandroRosa\DorisWidget\Block;


use LeandroRosa\DorisCatalogIntegrator\Helper\DorisCatalogIntegratorConfiguration;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\Session;
use Magento\Sales\Model\Order\Config;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Checkout\Block\Onepage\Success;
use Magento\Sales\Model\Order\Item;

class Order extends Success
{
    /**
     * @var Json
     */
    protected Json $serializer;

    /**
     * @var DorisCatalogIntegratorConfiguration
     */
    protected DorisCatalogIntegratorConfiguration $catalogIntegratorConfig;

    /**
     * @param Context $context
     * @param Session $checkoutSession
     * @param Config $orderConfig
     * @param HttpContext $httpContext
     * @param Json $serializer
     * @param DorisCatalogIntegratorConfiguration $catalogIntegratorConfig
     * @param array $data
     */
    public function __construct(
        Context                             $context,
        Session                             $checkoutSession,
        Config                              $orderConfig,
        HttpContext                         $httpContext,
        Json                                $serializer,
        DorisCatalogIntegratorConfiguration $catalogIntegratorConfig,
        array                               $data = []
    )
    {
        parent::__construct($context, $checkoutSession, $orderConfig, $httpContext, $data);
        $this->serializer = $serializer;
        $this->catalogIntegratorConfig = $catalogIntegratorConfig;
    }

    /**
     * @return string
     */
    public function getJsonConfig(): string
    {
        $order = $this->_checkoutSession->getLastRealOrder();
        $colorAttribute = $this->catalogIntegratorConfig->getColorAttribute('website', $order->getStore()->getWebsiteId());
        if (empty($colorAttribute)) {
            return '{}';
        }

        $products = [];
        foreach ($order->getItems() as $item) {
            if (!$item->isDeleted() && !$item->getParentItemId()) {
                $itemData = [
                    'identifier' => $this->getSku($item, $order->getStore()->getWebsiteId(), $colorAttribute),
                    'quantity' => (int)$item->getQtyOrdered(),
                    'total' => number_format((float)$item->getRowTotal() * $item->getQtyOrdered(), 2, '.', ''),
                    'sku' => $item->getSku(),
                ];
                $products[] = $itemData;
            }
        }

        return $this->serializer->serialize([
            'id' => $order->getIncrementId(),
            'value' => number_format((float)$order->getGrandTotal(), 2, '.', ''),
            'currency' => $order->getOrderCurrencyCode(),
            'products' => $products,
        ]);
    }

    /**
     * @param Item $item
     * @param int $websiteId
     * @param array $colorAttribute
     *
     * @return string
     */
    public function getSku(Item $item, int $websiteId, array $colorAttribute): string
    {
        if (empty($item->getProductOptions()['attributes_info'])) {
            return $item->getSku();
        }

        $colorLabel = null;
        foreach ($item->getProductOptions()['attributes_info'] as $attribute) {
            if ($attribute['option_id'] == $colorAttribute['attribute_id']) {
                $colorLabel = $attribute['value'];
                break;
            }
        }

        if (!$colorLabel) {
            return $item->getSku();
        }

        $parentSku = $item->getProduct()->getSku();
        return "{$parentSku}-{$colorLabel}";
    }
}
