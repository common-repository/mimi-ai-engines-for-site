<?php

namespace VietDevelopers\MiMi\ProductRecommendations;

/**
 * Product recommendations class
 */
class Manager
{
    /**
     * Constructor
     * 
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('woocommerce_after_single_product', array($this, 'display_frequently_bought_together_products_in_single_product'), 15);
        add_action('woocommerce_after_single_product', array($this, 'display_related_products_in_single_product'), 15);
    }

    public function display_frequently_bought_together_products_in_single_product()
    {
        if (class_exists('WooCommerce') & is_product()) {
            require_once MIMI_TEMPLATE_PATH . '/Front/FrequentlyBoughtTogetherProductsApp.php';
        }
    }

    public function display_related_products_in_single_product()
    {
        if (class_exists('WooCommerce') & is_product()) {
            require_once MIMI_TEMPLATE_PATH . '/Front/RelatedProductsApp.php';
        }
    }
}
