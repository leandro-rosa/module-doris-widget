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


use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Helper\Data as ProductHelper;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Store\Api\Data\WebsiteInterface;
use Magento\Swatches\Helper\Data as SwatchesHelper;
use Magento\Swatches\Block\Product\Renderer\Configurable as ConfigurableBlockRender;

use LeandroRosa\DorisCatalogIntegrator\Helper\DorisCatalogIntegratorConfiguration;

class InjectButton extends Template
{
    /**
     * @var ProductHelper
     */
    protected ProductHelper $productHelper;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    protected DorisCatalogIntegratorConfiguration $catalogIntegratorConfig;


    /**
     * @var SwatchesHelper
     */
    protected SwatchesHelper $swatchesHelper;

    /**
     * @var ConfigurableBlockRender
     */

    protected ConfigurableBlockRender $configurableBlockRender;

    /**
     * @param Context $context
     * @param ProductHelper $productHelper
     * @param SwatchesHelper $swatchesHelper
     * @param ProductRepositoryInterface $productRepository
     * @param DorisCatalogIntegratorConfiguration $catalogIntegratorConfig
     * @param ConfigurableBlockRender $configurableBlockRender
     * @param array $data
     */
    public function __construct(
        Context                             $context,
        ProductHelper                       $productHelper,
        SwatchesHelper                      $swatchesHelper,
        ProductRepositoryInterface          $productRepository,
        DorisCatalogIntegratorConfiguration $catalogIntegratorConfig,
        ConfigurableBlockRender             $configurableBlockRender,
        array                               $data = [],
    )
    {
        parent::__construct($context, $data);
        $this->productHelper = $productHelper;
        $this->productRepository = $productRepository;
        $this->swatchesHelper = $swatchesHelper;
        $this->catalogIntegratorConfig = $catalogIntegratorConfig;
        $this->configurableBlockRender = $configurableBlockRender;
    }

    /**
     * @return ProductInterface|null
     */
    public function getProductBySession(): ?ProductInterface
    {
        return $this->productHelper->getProduct();
    }

    /**
     * @param int $id
     *
     * @return ProductInterface
     *
     * @throws NoSuchEntityException
     */
    public function getProductById(int $id): ProductInterface
    {
        return $this->productRepository->getById($id);
    }

    /**
     * @param int|null $id
     *
     * @return ProductInterface|null
     *
     * @throws NoSuchEntityException
     */
    public function getProduct(?int $id = null): ?ProductInterface
    {
        return $id ? $this->getProductById($id) : $this->getProductBySession();
    }

    /**
     * @return string|null
     */
    public function getProductVariationsJsonConfig(): ?string
    {
        return $this->configurableBlockRender->getJsonSwatchConfig();
    }

    /**
     * @return string
     */
    public function getColorAttribute(): string
    {
        $attribute = $this->catalogIntegratorConfig->getColorAttribute();
        return empty($attribute) ? '{}' : json_encode($attribute);
    }

    /**
     * @return string
     */
    public function getSizeAttribute(): string
    {
        $attribute = $this->catalogIntegratorConfig->getSizeAttribute();
        return empty($attribute) ? '{}' : json_encode($attribute);
    }
}
