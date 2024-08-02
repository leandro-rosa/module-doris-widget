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
define(
    [
        'uiComponent',
        'ko',
        'jquery',
        'LeandroRosa_DorisWidget/js/init',
    ], function (
        Component,
        ko,
        $,
    ) {
        'use strict';

        return Component.extend({
            identifier: ko.observable(''),
            injectButtonOptions: {},

            initialize: function () {
                this._super();
                if (!this.options?.color_attribute?.attribute_id || !this.options?.size_attribute?.attribute_id) return

                const colorVariations = this.options.product_variations[this.options.color_attribute.attribute_id]
                const [firstColor] = Object.values(colorVariations)

                this.identifier(`${this.options.parent_sku}-${firstColor?.label}`);
                this.createInjectButton();

                $('body').on('updatePrice', () => {
                    if (!this.options?.color_attribute?.attribute_id) return;
                    const selectedColor = this.getSelectedProductColor();
                    if (!selectedColor) return;
                    this.identifier(`${this.options.parent_sku}-${this.options.product_variations[selectedColor.attribute_id][selectedColor.attribute_value].label}`);
                    this.createInjectButton();
                });

            },

            createInjectButton: function () {
                this.injectButtonOptions = {
                    selector: '#doris-trigger-wrapper',
                    skus: [this.identifier()],
                    validateSku: this.options.validateSku,
                    apiKey: this.options.apiKey,
                    description: this.options.description,
                    showBadge: this.options.showBadge
                }

                if (this.options.backgroundImages && this.options.backgroundImages.length) {
                    this.injectButtonOptions['backgroundImages'] = this.options.backgroundImages;
                }

                try {
                    window.DorisWidget.injectButton(this.injectButtonOptions)
                } catch (error) {
                    console.error('Error DorisWidget.injectButton: Product super attributes is empty.', {error});
                }
            },

            getSelectedProductColor: function () {
                const colorElement = $(`div.swatch-attribute.${this.options.color_attribute.attribute_code}`);

                const attributeId = colorElement.attr('data-attribute-id');
                const optionSelected = colorElement.attr('data-option-selected');
                if (!attributeId || !optionSelected) return

                return {attribute_id: attributeId, attribute_value: optionSelected}
            },
        });
    }
);
