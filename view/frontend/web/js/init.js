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
        'DorisWidget',
        'LeandroRosa_DorisWidget/js/handle-buy-button',
        'jquery'
    ], function (
        Component,
        DorisWidget,
        handleBuyButton,
    ) {
        'use strict';

        return Component.extend({
            initOptions: {},

            initialize: function () {
                this._super();
                this.init();
            },

            init: function () {
                this.initOptions = {
                    apiKey: this.options.apiKey,
                    splashImage: this.options.splashImage,
                    totemExperience: this.options.totemExperience,
                    position: {x: this.options.position.x},
                    theme: {colors: {primary: this.options.theme.colors.primary}},
                    handleBuyButton: (skus) => {
                        handleBuyButton(skus);
                    },
                    handleGoToCartButton: () => {
                        window.location.href = `${window.BASE_URL}checkout/cart`;
                    }
                };

                try {
                    window.DorisWidget = DorisWidget;
                    window.DorisWidget.init(this.initOptions);
                } catch (error) {
                    console.error('Error DorisWidget.init: Error to init.', {error});
                }
            },
        });
    }
);
