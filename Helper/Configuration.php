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

namespace LeandroRosa\DorisWidget\Helper;


use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Configuration
 *
 * @package LeandroRosa\DorisWidget\Helper
 */
class Configuration extends AbstractHelper
{
    const IS_ENABLED_PATH_CONFIG = 'doris_widget/init/active';
    const COLOR_PATH_CONFIG = 'doris_widget/init/color';
    const SPLASH_IMAGE_PATH_CONFIG = 'doris_widget/init/splash_image';
    const TOTEM_EXPERIENCE_PATH_CONFIG = 'doris_widget/init/use_totem_experience';
    const USE_WIDGET_IN_RIGHT_POSITION_PATH_CONFIG = 'doris_widget/init/use_widget_in_right_position';
    const VALIDATE_SKU_PATH_CONFIG = 'doris_widget/inject_button/validate_sku';
    const SHOW_BADGE_PATH_CONFIG = 'doris_widget/inject_button/show_badge';
    const DESCRIPTION_PATH_CONFIG = 'doris_widget/inject_button/description';
    const BACKGROUND_IMAGES_PATH_CONFIG = 'doris_widget/inject_button/background_images';

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return bool
     */
    public function isEnable($scopeType = 'website', $scopeCode = null): bool
    {
        return (bool)$this->scopeConfig->getValue(static::IS_ENABLED_PATH_CONFIG, $scopeType, $scopeCode);
    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return string|null
     */
    public function getColor($scopeType = 'website', $scopeCode = null): ?string
    {
        return $this->scopeConfig->getValue(static::COLOR_PATH_CONFIG, $scopeType, $scopeCode);
    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return string|null
     */
    public function getSplashImage($scopeType = 'website', $scopeCode = null): ?string
    {
        return $this->scopeConfig->getValue(static::SPLASH_IMAGE_PATH_CONFIG, $scopeType, $scopeCode);
    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return string
     */
    public function useTotemExperience($scopeType = 'website', $scopeCode = null): string
    {
        $configValue = $this->scopeConfig->getValue(static::TOTEM_EXPERIENCE_PATH_CONFIG, $scopeType, $scopeCode);
        return (bool)$configValue ? 'true' : 'false';

    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return string
     */
    public function getWidgetPosition($scopeType = 'website', $scopeCode = null): string
    {
        $configValue = $this->scopeConfig->getValue(static::USE_WIDGET_IN_RIGHT_POSITION_PATH_CONFIG, $scopeType, $scopeCode);
        return (bool)$configValue ? 'right' : 'left';
    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return string
     */
    public function shouldValidateSku($scopeType = 'website', $scopeCode = null): string
    {
        $configValue = $this->scopeConfig->getValue(static::VALIDATE_SKU_PATH_CONFIG, $scopeType, $scopeCode);
        return (bool)$configValue ? 'true' : 'false';
    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return string
     */
    public function shouldShowBadge($scopeType = 'website', $scopeCode = null): string
    {
        $configValue = $this->scopeConfig->getValue(static::SHOW_BADGE_PATH_CONFIG, $scopeType, $scopeCode);
        return (bool)$configValue ? 'true' : 'false';
    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return string|null
     */
    public function getDescription($scopeType = 'website', $scopeCode = null): ?string
    {
        return $this->scopeConfig->getValue(static::DESCRIPTION_PATH_CONFIG, $scopeType, $scopeCode);
    }

    /**
     * @param $scopeType
     * @param $scopeCode
     *
     * @return array
     */
    public function getBackgroundImages($scopeType = 'website', $scopeCode = null): array
    {
        $backgroundImages = json_decode((string)$this->scopeConfig->getValue(static::BACKGROUND_IMAGES_PATH_CONFIG, $scopeType, $scopeCode), true) ?? [];
        $result = [];

        foreach ($backgroundImages as $backgroundImage) {
            $result[] = $backgroundImage['background_image_url'];
        }

        return $result;
    }
}
