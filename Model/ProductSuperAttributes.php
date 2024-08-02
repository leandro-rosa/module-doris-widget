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

namespace LeandroRosa\DorisWidget\Model;

use LeandroRosa\DorisWidget\Api\ProductSuperAttributesInterface;
use Magento\Framework\DataObject;

class ProductSuperAttributes extends DataObject implements ProductSuperAttributesInterface
{
    /**
     * @inheritDoc
     */
    public function getParentId()
    {
        return $this->_getData(self::PARENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function getSku()
    {
        return $this->_getData(self::SKU);
    }

    /**
     * @inheritDoc
     */
    public function getColorSuperAttributeId()
    {
        return $this->_getData(self::COLOR_SUPER_ATTRIBUTE_ID);
    }

    /**
     * @inheritDoc
     */
    public function getColorSuperAttributeValue()
    {
        return $this->_getData(self::COLOR_SUPER_ATTRIBUTE_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function getSizeSuperAttributeId()
    {
        return $this->_getData(self::SIZE_SUPER_ATTRIBUTE_ID);
    }

    /**
     * @inheritDoc
     */
    public function getSizeSuperAttributeValue()
    {
        return $this->_getData(self::SIZE_SUPER_ATTRIBUTE_VALUE);
    }

}
