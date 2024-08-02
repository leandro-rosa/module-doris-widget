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

namespace LeandroRosa\DorisWidget\Api;


interface ProductSuperAttributesInterface
{
    const SKU = 'sku';
    const PARENT_ID = 'parent_id';
    const COLOR_SUPER_ATTRIBUTE_ID = 'color_super_attribute_id';
    const COLOR_SUPER_ATTRIBUTE_VALUE = 'color_super_attribute_value';
    const SIZE_SUPER_ATTRIBUTE_ID = 'size_super_attribute_id';
    const SIZE_SUPER_ATTRIBUTE_VALUE = 'size_super_attribute_value';

    /**
     * @return string|null
     */
    public function getParentId();

    /**
     * @return string|null
     */
    public function getSku();

    /**
     * @return int|null
     */
    public function getColorSuperAttributeId();

    /**
     * @return string|null
     */
    public function getColorSuperAttributeValue();

    /**
     * @return int|null
     */
    public function getSizeSuperAttributeId();

    /**
     * @return string|null
     */
    public function getSizeSuperAttributeValue();
}
