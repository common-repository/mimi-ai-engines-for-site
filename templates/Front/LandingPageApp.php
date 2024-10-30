<?php
/*
Template Name: MiMi Landing PAge
*/

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

// wp_head();

// Lấy biến từ query
$dataTemplate = get_query_var('mimi_data_template');

$style = $dataTemplate['style'];
$generateContentFor = $dataTemplate['genrateContentFor'];
$products = $dataTemplate['products'];
$product = $products[0];

if ($generateContentFor == 'single-product') {
    $productID = $product['id'];
    $product_name = $product['name'];
    $product_url = $product['url'];
    $product_description = $product['description'];
    $product_thumbnailURL = $product['thumbnailURL'];
    $product_categories = $product['categories'];
    $originalPrice = $product['originalPrice'];
    $salePrice = $product['salePrice'];
    $product_images = $product['images'];
    $percentSale = $product['percentSale'];
    $reviewCount = $product['reviewCount'];
    $linkAddToCart = get_bloginfo('url', 'display') . '?add-to-cart=' . $productID;
}

switch ($style) {
    case 'mimi-landing-page-style-6':
        include MIMI_TEMPLATE_PATH . '/Front/landing-page/mimi-landing-page-style-6/LandingPageStyle6.php';
        break;
    case 'mimi-landing-page-style-7':
        include MIMI_TEMPLATE_PATH . '/Front/landing-page/mimi-landing-page-style-7/LandingPageStyle7.php';
        break;
    case 'mimi-landing-page-style-8':
        include MIMI_TEMPLATE_PATH . '/Front/landing-page/mimi-landing-page-style-8/LandingPageStyle8.php';
        break;

    default:
        echo "null";
}

// wp_footer();
