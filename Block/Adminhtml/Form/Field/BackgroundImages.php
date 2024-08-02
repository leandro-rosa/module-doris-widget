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

namespace LeandroRosa\DorisWidget\Block\Adminhtml\Form\Field;

use LeandroRosa\DorisCatalogIntegrator\Block\Adminhtml\Form\Field\DorisCategory;
use Magento\Framework\View\Element\Text;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class BackgroundImages extends AbstractFieldArray
{
    /**
     * @var Text|null
     */
    protected ?Text $backgroundImageUrlsRender;

    /**
     * @inheritDoc
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('background_image_url', [
            'label' => __('Background image URL'),
            'class' => 'required-entry',
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * @param DataObject $row
     *
     * @return void
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $backgroundImageUrls = $row->getData('background_image_url');

//        if ($backgroundImageUrls) {
//            $options['option_' . $this->getBackgroundImageUrlRender()->calcOptionHash(\json_encode($backgroundImageUrls))] = 'selected="selected"';
//        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return Text
     *
     * @throws LocalizedException
     */
    protected function getBackgroundImageUrlRender(): Text
    {
        if (empty($this->backgroundImageUrlsRender)) {
            $this->backgroundImageUrlsRender = $this->getLayout()->createBlock(
                Text::class,
                'background_image_url',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->backgroundImageUrlsRender;
    }

}
