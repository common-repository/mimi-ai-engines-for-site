<?php

namespace VietDevelopers\MiMi\DataExport;

/**
 * Class Data Export.
 * 
 * Export Data From Wordpress database
 */
class Manager
{
    /**
     * Export data.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function export_all_datas()
    {
        $data = array(
            "site" => get_bloginfo('url', 'display'),
            "title" => get_bloginfo('name'),
            "products" => \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::export_woocomerce_products(),
            "posts" => \VietDevelopers\MiMi\DataExport\WPPostsExport::export_WPPostsData(),
        );

        return $data;
    }

    /**
     * Export products.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function export_only_products()
    {
        $data = array(
            "site" => get_bloginfo('url', 'display'),
            "title" => get_bloginfo('name'),
            "products" => \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::export_woocomerce_products(),
        );

        return $data;
    }

    /**
     * Export product orders.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function export_all_orders()
    {
        $data = array(
            "site" => get_bloginfo('url', 'display'),
            "title" => get_bloginfo('name'),
            "transactions" => \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::export_woocomerce_orders(),
        );

        return $data;
    }

    /**
     * Export best sellings products.
     *
     * @since 1.1.0
     *
     * @return string
     */
    public static function export_best_sellings_products($limit)
    {
        $data = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::get_best_selling_products($limit);

        return $data;
    }

    /**
     * Export newest products.
     *
     * @since 1.1.0
     *
     * @return string
     */
    public static function export_newest_products($limit)
    {
        $data = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::get_newest_products($limit);

        return $data;
    }

    /**
     * Export in-stock products.
     *
     * @since 1.1.0
     *
     * @return string
     */
    public static function export_in_stock_products($limit)
    {
        $data = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::get_in_stock_products($limit);

        return $data;
    }

    /**
     * Export paginated products
     *
     * @since 1.1.0
     *
     * @return string
     */
    public static function export_paginated_products($limit, $paged = 1, $query = '')
    {
        $data = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::get_paginated_products($paged, $limit, $query);

        return $data;
    }

    /**
     * Export products by product_ids
     *
     * @since 1.1.0
     *
     * @return array
     */
    public static function export_products_by_ids($product_ids)
    {
        $data = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::get_products_by_ids($product_ids);

        return $data;
    }

    /**
     * Export product detail by product_id
     *
     * @since 1.1.0
     *
     * @return array
     */
    public static function export_product_detail($product_id, $originalPrice, $isForSale, $salePrice)
    {
        $data = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::get_product_detail($product_id, $originalPrice, $isForSale, $salePrice);

        return $data;
    }

    /**
     * Export product detail to view by product_id
     *
     * @since 1.1.0
     *
     * @return array
     */
    public static function export_product_detail_to_view($product_id, $originalPrice, $isForSale, $salePrice)
    {
        $data = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::get_product_detail_to_view($product_id, $originalPrice, $isForSale, $salePrice);

        return $data;
    }
}
