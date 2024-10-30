<?php

namespace VietDevelopers\MiMi\DataExport;

use WP_Query;

/**
 * Class Woocommerce Products Export.
 *
 * @since 1.0.0
 */
class WoocommerceProductsExport
{
    /**
     * Export woocommerce products.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public static function export_woocomerce_products()
    {
        // Mảng để lưu thông tin về sản phẩm
        $products_array = array();

        if (class_exists('WooCommerce')) {
            // Lấy danh sách tất cả sản phẩm
            $products = wc_get_products(
                array(
                    'status' => 'publish',
                    'limit' => -1, // Lấy tất cả sản phẩm
                )
            );

            // Loop qua từng sản phẩm
            foreach ($products as $product) {
                // Lấy toàn bộ thông tin về sản phẩm
                $product_info = self::get_info_parent_product($product);

                // Thêm thông tin sản phẩm vào mảng
                $products_array[] = $product_info;
            }
        }

        return $products_array;
    }

    /**
     * Export woocommerce orders
     * 
     * @since 1.0.0
     * 
     * @return array
     */
    public static function export_woocomerce_orders()
    {
        // Initialize an empty array to store the results
        $completed_orders_array = array();

        if (class_exists('WooCommerce')) {
            // Get all completed orders
            $completed_orders = wc_get_orders(
                array(
                    'status' => 'completed',
                    'limit' => -1, // Get all orders, use -1 for unlimited
                )
            );

            // Loop through each completed order
            foreach ($completed_orders as $order) {
                // Get order ID
                $order_id = $order->get_id();

                // Initialize an empty array to store items in the current order
                $order_items = array();

                // Get items in the order
                $items = $order->get_items();

                // Loop through each item
                foreach ($items as $item) {
                    // Get item details
                    $product_id = $item->get_product_id();

                    // Add product ID to the order items array
                    $order_items[] = $product_id;
                }

                // Add order ID and items to the completed orders array
                $completed_orders_array[] = array(
                    'id' => $order_id,
                    'items' => $order_items
                );
            }
        }

        // Return the completed orders array
        return $completed_orders_array;
    }

    public static function get_product_detail($product_id, $originalPrice, $isForSale, $salePrice)
    {
        $product = wc_get_product($product_id);

        if (!$product) {
            return array();
        }

        return array(
            'name' => $product->get_name(),
            'description' => $product->get_description(),
            'categories' => self::get_categories_product_detail($product),
            'originalPrice' => $originalPrice,
            'isForSale' => $isForSale,
            'salePrice' => $salePrice,
        );
    }

    public static function get_product_detail_to_view($product_id, $originalPrice, $isForSale, $salePrice)
    {
        $product = wc_get_product($product_id);

        if (!$product) {
            return array();
        }

        $name = $product->get_name();
        $thumnailURL = get_the_post_thumbnail_url($product->get_id()) != false ? get_the_post_thumbnail_url($product->get_id()) : "";

        $product_images = array();

        $attachment_ids = $product->get_gallery_image_ids();

        $index = 0;
        foreach ($attachment_ids as $attachment_id) {
            $image_name = $name . '-' . $index;
            // Display the image URL
            $Original_image_url = wp_get_attachment_url($attachment_id);

            // $product_images[] = \VietDevelopers\MiMi\Utils\RemoveBackgroundAPI::do_remove_bg($Original_image_url, $image_name);
            $product_images[] = $Original_image_url;


            $index++;
        }

        $percentSale = $salePrice ? (($originalPrice - $salePrice) / $originalPrice) * 100 : 100;

        return array(
            'id' => $product->get_id(),
            'name' => $name,
            'url' => get_permalink($product->get_id()),
            'description' => $product->get_description(),
            // 'thumbnailURL' =>  \VietDevelopers\MiMi\Utils\RemoveBackgroundAPI::do_remove_bg($thumnailURL, $name),
            'thumbnailURL' => $thumnailURL,
            'categories' => self::get_categories_product($product),
            'originalPrice' => $originalPrice . ' ' . get_woocommerce_currency(),
            'salePrice' => $salePrice . ' ' . get_woocommerce_currency(),
            'images' => $product_images,
            'percentSale' => round($percentSale),
            'reviewCount' => $product->get_review_count(),
        );
    }

    /**
     * Get products by ids
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_products_by_ids($product_ids)
    {
        // Kiểm tra xem WooCommerce đã được kích hoạt chưa
        if (!class_exists('WooCommerce')) {
            return array();
        }

        // Khởi tạo mảng để lưu thông tin sản phẩm
        $product_info = array();

        // Lặp qua mỗi ID sản phẩm được truyền vào
        foreach ($product_ids as $product_id) {
            if ($product_id != 0) {
                // Lấy thông tin sản phẩm dựa trên ID
                $product = wc_get_product($product_id);

                $product_info[] = self::get_info_product($product);
            }
        }

        return $product_info;
    }

    /**
     * Get best selling products 
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_best_selling_products($limit)
    {
        $best_selling_products_array = array();

        if (class_exists('WooCommerce')) {
            // Query WooCommerce for best-selling products
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $limit,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            );

            $query = new WP_Query($args);

            // Loop through each product
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    global $product;
                    $best_selling_products_array[] = self::get_info_product($product);
                }
                // Reset the query after the loop
                wp_reset_postdata();
            }
        }

        return $best_selling_products_array;
    }


    /**
     * Get in-stock products 
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_in_stock_products($limit)
    {
        $in_stock_products_array = array();

        if (class_exists('WooCommerce')) {
            // Query WooCommerce for in-stock products
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $limit,
                'meta_query' => array(
                    array(
                        'key' => '_stock_status',
                        'value' => 'instock',
                        'compare' => '='
                    )
                )
            );

            $query = new WP_Query($args);

            // Loop through each product
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    $in_stock_products_array[] = self::get_info_product($product);
                }
                // Reset the query after the loop
                wp_reset_postdata();
            }
        }

        return $in_stock_products_array;
    }

    /**
     * Get newest products 
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_newest_products($limit)
    {
        $newest_products_array = array();

        if (class_exists('WooCommerce')) {
            // Query WooCommerce for newest products
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $limit,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $query = new WP_Query($args);

            // Loop through each product
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    global $product;

                    $newest_products_array[] = self::get_info_product($product);

                    // Reset the query
                    wp_reset_postdata();
                    wp_reset_query();
                }
            }
        }

        return $newest_products_array;
    }

    /**
     * Get paginated products 
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_paginated_products($paged, $limit, $query)
    {
        $products = array();
        $total_pages = 0;

        if (class_exists('WooCommerce')) {
            // Query WooCommerce for products with pagination
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $limit,
                'paged' => $paged,
            );

            // Add search query if a search term is provided
            if (!empty($query)) {
                $args['s'] = $query;
            }

            $query = new WP_Query($args);

            // Loop through each product
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    global $product;

                    $products[] = self::get_info_product($product);

                    // Reset the query
                    wp_reset_postdata();
                    wp_reset_query();
                }

                $total_pages = $query->max_num_pages;
            }
        }

        return array(
            'products' => $products,
            'total_pages' => $total_pages,
        );
    }


    /**
     * Get info product
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    private static function get_info_product($product)
    {
        return array(
            'id' => $product->get_id(),
            'name' => $product->get_name(),
            "originalPrice" => self::get_regular_price_parent_prodcut($product),
            "salePrice" => self::get_sale_price_parent_product($product),
            'current_quantity' => $product->get_stock_quantity(),
            'thumbnail' => get_the_post_thumbnail_url($product->get_id()),
            'url' => get_permalink($product->get_id()),
            'categories' => self::get_categories_product($product)
        );
    }

    /**
     * Get info parent product
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_info_parent_product($product)
    {
        $info_product_array = array(
            "type" => "product",
            "id" => $product->get_id(),
            "url" => get_permalink($product->get_id()),
            "slug" => $product->get_slug(),
            "name" => $product->get_name(),
            "status" => self::get_str_stock_status($product->get_stock_status()),
            "thumbnailURL" => get_the_post_thumbnail_url($product->get_id()) != false ? get_the_post_thumbnail_url($product->get_id()) : "",
            "tags" => self::get_tags_product($product),
            "description" => $product->get_short_description(),
            "category" => self::get_categories_product($product),
            "attributes" => self::get_attributes_product($product),
            "regularPrice" => self::get_regular_price_parent_prodcut($product),
            "salePrice" => self::get_sale_price_parent_product($product),
            "variations" => self::get_variations_product($product)
        );

        return $info_product_array;
    }

    /**
     * Get stock status
     *
     * @since 1.0.0
     *
     * @return string
     */
    private static function get_str_stock_status($stock_status)
    {
        switch ($stock_status) {
            case 'instock':
                return 'In stock';
                break;
            case 'outofstock':
                return 'Out of stock';
                break;
            case 'onbackorder':
                return 'On back order';
                break;
            default:
                return 'Unknown';
                break;
        }
    }

    /**
     * Get tags
     *
     * @since 1.0.0
     *
     * @return string
     */
    private static function get_tags_product($product)
    {
        $tags = get_the_terms($product->get_id(), 'product_tag');

        $tags_array = [];

        // Kiểm tra xem $tags có phải là mảng và có ít nhất một phần tử không
        if (is_array($tags) && count($tags) > 0) {
            foreach ($tags as $tag) {
                $tags_array[] = $tag->name;
            }
        }

        $tags_str = implode(', ', $tags_array);
        return $tags_str;
    }

    /**
     * Get categories of product
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_categories_product($product)
    {
        $categories = get_the_terms($product->get_id(), 'product_cat');

        $categories_array = [];

        // Kiểm tra xem $tags có phải là mảng và có ít nhất một phần tử không
        if (is_array($categories) && count($categories) > 0) {
            foreach ($categories as $category) {
                $categories_array[] = $category->name;
            }
        }

        $categories_str = implode(', ', $categories_array);

        return $categories_str;
    }

    /**
     * Get categories of product
     *
     * @since 1.1.0
     *
     * @return array
     */
    private static function get_categories_product_detail($product)
    {
        $categories = get_the_terms($product->get_id(), 'product_cat');

        $categories_array = [];

        // Kiểm tra xem $tags có phải là mảng và có ít nhất một phần tử không
        if (is_array($categories) && count($categories) > 0) {
            foreach ($categories as $category) {
                $categories_array[] = $category->name;
            }
        }


        return $categories_array;
    }

    /**
     * Get attributes of product
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_attributes_product($product)
    {
        $attributes = $product->get_attributes();

        $attributes_array = [];

        if (is_array($attributes) && count($attributes) > 0) {
            foreach ($attributes as $attribute) {

                $id = $attribute['id'];
                $name = $attribute['name'];
                $options = $attribute['options'];

                $options_array = [];

                if (is_array($options) && count($options) > 0) {
                    foreach ($options as $option) {

                        if (is_numeric($option)) {
                            $option_value = get_term($option);
                            if (!empty($option_value->slug)) {
                                $options_array[] = $option_value->slug;
                            }
                        } else {
                            $options_array[] = $option;
                        }
                    }
                }

                $newName = str_replace("pa_", "", $name);
                $options_str = implode(', ', $options_array);

                $attributes_array[] = array(
                    $newName => $options_str,
                );
            }
        }

        return $attributes_array;
    }

    /**
     * Get regular price of parent product
     *
     * @since 1.0.0
     *
     * @return string
     */
    private static function get_regular_price_parent_prodcut($product)
    {
        $regular_price = "";
        $currency = get_woocommerce_currency();

        $type_product = $product->get_type();

        if ($type_product == "simple") {
            $regular_price = $product->get_regular_price();
        }

        // if ($type_product == "grouped") {
        //     $products_array[] = $type_product;
        // }

        // if ($type_product == "external") {
        //     $products_array[] = $type_product;
        // }

        if ($type_product == "variable") {
            $variation_ids = $product->get_children();
            $regular_prices_array = self::get_regular_prices_of_all_variations($variation_ids);
            if (count($regular_prices_array) > 0) {
                $max_price = max($regular_prices_array);

                $regular_price = $max_price;
            }
        }

        $regular_price_str = empty($regular_price) ? "" : $regular_price . ' ' . $currency;
        return $regular_price_str;
    }

    /**
     * Get sale price of parent product
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_sale_price_parent_product($product)
    {
        $sale_price = "";

        $currency = get_woocommerce_currency();

        $type_product = $product->get_type();

        if ($type_product == "simple") {
            $sale_price = $product->get_sale_price();
        }

        // if ($type_product == "grouped") {
        //     $products_array[] = $type_product;
        // }

        // if ($type_product == "external") {
        //     $products_array[] = $type_product;
        // }

        if ($type_product == "variable") {
            $variation_ids = $product->get_children();
            $sale_prices_array = self::get_sale_prices_of_all_variations($variation_ids);

            if (count($sale_prices_array) > 0) {
                $min_price = min($sale_prices_array);

                $sale_price = $min_price;
            }
        }

        $sale_price_str = empty($sale_price) ? "" : $sale_price . ' ' . $currency;

        return $sale_price_str;
    }

    /**
     * Get variations of product
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_variations_product($product)
    {
        $variations_array = [];

        $variation_ids = $product->get_children();

        if (is_array($variation_ids) && count($variation_ids) > 0) {
            foreach ($variation_ids as $variation_id) {

                $variation = wc_get_product($variation_id);

                if ($variation && $variation->is_type('variation')) {

                    // Variation found and is a valid variation type
                    $variation_attributes = $variation->get_attributes();

                    $variation_attributes_array = [];

                    if (is_array($variation_attributes) && count($variation_attributes) > 0) {
                        foreach ($variation_attributes as $key => $value) {

                            $name = $key;
                            $newName = str_replace("pa_", "", $name);

                            $attribute = array(
                                $newName => $value,
                            );

                            $variation_attributes_array[] = $attribute;
                        }
                    }

                    $currency = get_woocommerce_currency();

                    $regular_price = empty($variation->get_regular_price()) ? "" : $variation->get_regular_price() . ' ' . $currency;
                    $sale_price = empty($variation->get_sale_price()) ? "" : $variation->get_sale_price() . ' ' . $currency;

                    $variation_data = array(
                        "id" => $variation_id,
                        "attributes" => $variation_attributes_array,
                        "sku" => $variation->get_sku(),
                        "imageURL" => get_the_post_thumbnail_url($variation_id, 'full'), // Adjust image size as needed
                        "regularPrice" => $regular_price,
                        "salePrice" => $sale_price,
                        "status" => self::get_str_stock_status($variation->get_stock_status()),
                        "description" => $variation->get_description(),
                    );

                    $variations_array[] = $variation_data;
                }
            }
        }

        return $variations_array;
    }

    /**
     * Get regular price of all variations
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_regular_prices_of_all_variations($variation_ids)
    {
        $regular_price_array = array();

        if (is_array($variation_ids) && count($variation_ids) > 0) {
            foreach ($variation_ids as $variation_id) {
                $variation = wc_get_product($variation_id);

                if ($variation !== false) {
                    $regular_price = $variation->get_regular_price();
                    array_push($regular_price_array, $regular_price);
                }
            }
        }

        return $regular_price_array;
    }

    /**
     * Get sale price of all variations
     *
     * @since 1.0.0
     *
     * @return array
     */
    private static function get_sale_prices_of_all_variations($variation_ids)
    {
        $sale_price_array = array();

        if (is_array($variation_ids) && count($variation_ids) > 0) {
            foreach ($variation_ids as $variation_id) {
                $variation = wc_get_product($variation_id);

                if ($variation !== false) {
                    $sale_price = $variation->get_sale_price();
                    array_push($sale_price_array, $sale_price);
                }
            }
        }

        return $sale_price_array;
    }
}
