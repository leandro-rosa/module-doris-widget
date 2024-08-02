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

namespace LeandroRosa\DorisWidget\Model\Services;

use LeandroRosa\DorisCatalogIntegrator\Helper\DorisCatalogIntegratorConfiguration;
use LeandroRosa\DorisWidget\Api\ProductServiceInterface;
use LeandroRosa\DorisWidget\Api\ProductSuperAttributesInterfaceFactory;
use LeandroRosa\DorisWidget\Api\ProductSuperAttributesInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Webapi\Exception;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class ProductService implements ProductServiceInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    /**
     * @var DorisCatalogIntegratorConfiguration
     */
    protected DorisCatalogIntegratorConfiguration $dorisCatalogIntegratorConfig;

    /**
     * @var ProductSuperAttributesInterfaceFactory
     */
    protected ProductSuperAttributesInterfaceFactory $productSuperAttributesFactory;

    /**
     * @var Configurable
     */
    protected Configurable $productConfigurable;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param DorisCatalogIntegratorConfiguration $dorisCatalogIntegratorConfig
     * @param ProductSuperAttributesInterfaceFactory $productSuperAttributesFactory
     * @param Configurable $productConfigurable
     */
    public function __construct(
        ProductRepositoryInterface             $productRepository,
        DorisCatalogIntegratorConfiguration    $dorisCatalogIntegratorConfig,
        ProductSuperAttributesInterfaceFactory $productSuperAttributesFactory,
        Configurable                           $productConfigurable
    )
    {
        $this->productRepository = $productRepository;
        $this->dorisCatalogIntegratorConfig = $dorisCatalogIntegratorConfig;
        $this->productSuperAttributesFactory = $productSuperAttributesFactory;
        $this->productConfigurable = $productConfigurable;
    }

    /**
     * @param string $sku
     *
     * @return ProductSuperAttributesInterface
     *
     * @throws Exception
     */
    public function getProductSuperAttributes($sku): ProductSuperAttributesInterface
    {
        $colorAttribute = $this->dorisCatalogIntegratorConfig->getColorAttribute();
        if (empty($colorAttribute['attribute_id'])) {
            throw new Exception(__('The color attribute is not configured.'));
        }
        $sizeAttribute = $this->dorisCatalogIntegratorConfig->getSizeAttribute();
        if (empty($sizeAttribute['attribute_id'])) {
            throw new Exception(__('The size attribute is not configured.'), 422);
        }

        $colorAttributeId = (int)$colorAttribute['attribute_id'];
        $sizeAttributeId = (int)$sizeAttribute['attribute_id'];

        try {
            $product = $this->productRepository->get($sku);
            $parentProduct = $this->productConfigurable->getParentIdsByChild($product->getId());
        } catch (\Exception $exception) {
            throw new Exception(__('Error: Sku not found. - Sku: %s', $sku), 422);
        }

        return $this->productSuperAttributesFactory->create(['data' => [
            'parent_id' => $parentProduct[0],
            'sku' => $sku,
            'color_super_attribute_id' => $colorAttributeId,
            'color_super_attribute_value' => $product->getData($colorAttribute['attribute_code']),
            'size_super_attribute_id' => $sizeAttributeId,
            'size_super_attribute_value' => $product->getData($sizeAttribute['attribute_code']),
        ]]);
    }
}
