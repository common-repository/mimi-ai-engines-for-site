<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

use VietDevelopers\MiMi\Common\CustomizeKeys;
use VietDevelopers\MiMi\Common\Keys;

global $product;

// Kiểm tra nếu sản phẩm có Related Products
if (!$product) {
    return;
}

$productID = $product->get_id();

$default_recommendation_settings = array(
    'similarProducts' => 0,
    'frequentlyBoughtTogetherProducts' => 1,
    'numberOfProduct' => 4
);

$recommendation_settings = get_option(Keys::MIMI_RECOMMENDATION_SETTINGS) ? get_option(Keys::MIMI_RECOMMENDATION_SETTINGS) : $default_recommendation_settings;
$numberOfProduct = $recommendation_settings['numberOfProduct'];
$frequentlyBoughtTogetherProductsSetting = $recommendation_settings['frequentlyBoughtTogetherProducts'];
$recommendationStyle = get_theme_mod(CustomizeKeys::MIMI_PRODUCT_RECOMMENDATIONS_RECOMMENDATION_STYLE_ON_THE_DETAIL_PRODUCT_PAGE_SETTING);
$result_color_hover = get_theme_mod(CustomizeKeys::MIMI_LIVE_RESULTS_COLOR_SETTING);

?>

<div id="mimi-frequently-bought-together-products-app" data-platform="wordpress" data-value="<?php echo esc_attr($productID) ?>" data-number-of-product="<?php echo esc_attr($numberOfProduct) ?>" data-frequently-setting="<?php echo esc_attr($frequentlyBoughtTogetherProductsSetting) ?>" data-recommendation-style="<?php echo esc_attr($recommendationStyle) ?>" data-result-color-hover="<?php echo esc_attr($result_color_hover) ?>">
    <h2>
        <?php esc_html_e('Loading', 'mimi'); ?>...
    </h2>
</div>