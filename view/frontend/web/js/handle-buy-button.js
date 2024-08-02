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
define([
    'Magento_Catalog/js/catalog-add-to-cart',
    'mage/storage',
    'jquery',
], function (
    catalogAddToCart,
    storage,
    $
) {
    'use strict';

    function _createAddToCartForm(response) {
        const formElement = document.createElement('form');
        formElement.id = `doris_product_addtocart_form-${response.sku}`;
        formElement.action = '/checkout/cart/add';

        function _addFormField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            formElement.appendChild(input);
        }

        _addFormField('product', response.parent_id)
        _addFormField('item', response.parent_id);
        _addFormField('form_key', $.cookie('form_key'));
        _addFormField(`super_attribute[${response.color_super_attribute_id}]`, response.color_super_attribute_value);
        _addFormField(`super_attribute[${response.size_super_attribute_id}]`, response.size_super_attribute_value);
        _addFormField('qty', 1);

        return $(formElement);
    }

    function handleBuyButton(skus) {
        if (!Array.isArray(skus)) skus = [skus];
        skus.forEach(sku => {
            storage
                .get(`rest/V1/doris/product-options/${sku}`)
                .done(response => {
                    const addToCartForm = _createAddToCartForm(response);
                    if (!addToCartForm) {
                        console.error('Error DorisWidget.handleBuyButton: get super attributes.', {response});
                        return;
                    }

                    try {
                        catalogAddToCart({bindSubmit: false}).submitForm(addToCartForm);
                    } catch (error) {
                        console.error('Error DorisWidget.handleBuyButton: add product to cart', error)
                    }
                })
                .fail((xhr, status, errorThrown) => {
                    console.error('Error DorisWidget.handleBuyButton: get super attributes.', {
                        status,
                        errorThrown,
                        xhr
                    });
                });
        });
    }

    return handleBuyButton;
});
