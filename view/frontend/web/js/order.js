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
        'jquery',
        'LeandroRosa_DorisWidget/js/init'
    ], function (Component, $) {
        'use strict';

        return Component.extend({
            initialize: function () {
                this._super();
                try {
                    this.placeOrder();
                } catch (error) {
                    console.error(error);
                }
            },

            placeOrder: function () {
                if (!this.options?.order_payload?.id) return;
                window.DorisWidget.order(this.options.order_payload);
            }
        })
    }
);
