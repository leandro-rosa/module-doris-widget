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

namespace LeandroRosa\DorisWidget\Model\SourceModel\Config\Backend;

use Magento\Framework\Exception\LocalizedException;
use Magento\Config\Model\Config\Backend\Serialized;

class BackgroundImages extends Serialized
{

    /**
     * @return BackgroundImages
     *
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();

        if (!is_array($value)) {
            throw new LocalizedException(__('Invalid background images urls.'));
        }

        if (isset($value['__empty'])) {
            unset($value['__empty']);
        }

        $this->setValue(\json_encode($value));

        return parent::beforeSave();
    }
}
