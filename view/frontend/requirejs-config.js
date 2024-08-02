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
const now = new Date();
// const DorisWidget = 'https://mix.stg.doris.services/doris-widget.js?d=' + now.toTimeString();
const DorisWidget = 'https://mix.doris.mobi/doris-widget.js?d=' + now.toTimeString();
const config = {
    map: {
        '*': {
            DorisWidget
        }
    },

    paths: {
        DorisWidget
    }
};
