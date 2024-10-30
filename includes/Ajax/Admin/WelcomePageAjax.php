<?php

namespace VietDevelopers\MiMi\Ajax\Admin;

use VietDevelopers\MiMi\Common\Keys;

/**
 * Welcome page ajax generator class.
 * 
 * Ensure admin welcome page ajax registration
 * 
 * @since 1.0.0
 */
class WelcomePageAjax
{
    private $status_imported_data;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->status_imported_data = get_option(Keys::MIMI_STATUS_IMPORTED_DATA);

        add_action('wp_ajax_mimi_init_site_ajax_action', array($this, 'init_site_ajax_callback'));
        add_action('wp_ajax_mimi_get_data_from_site_ajax_action', array($this, 'get_data_from_site_ajax_callback'));
        add_action('wp_ajax_mimi_update_status_imported_data_ajax_action', array($this, 'update_status_imported_data_ajax_callback'));
    }

    /**
     * Init site ajax
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function init_site_ajax_callback()
    {
        // Kiểm tra nonce
        check_ajax_referer('mimi_admin_nonce', 'nonce');

        // Kiểm tra quyền của người dùng
        if (!current_user_can('manage_options')) {
            $json = array(
                "isSuccess"     => false,
            );

            echo wp_json_encode($json);
            wp_die();
        }

        if ($this->status_imported_data == 0) {
            $admin_email = get_option('admin_email');
            $url_site = get_site_url();

            $keyAPI = \VietDevelopers\MiMi\Utils\MiMiAPI::do_init_site($admin_email, $url_site);

            if ($keyAPI !== 'error') {
                update_option(Keys::MIMI_API_KEY, $keyAPI);

                $url = admin_url('admin.php?page=mimi');
                $textWhenDone = __('Congratulation! All initial jobs has completed. Now you can start explore the power of MiMi', 'mimi');

                $json = array(
                    "isSuccess"     => true,
                    "url"           => $url,
                    "textWhenDone"  => $textWhenDone
                );

                echo wp_json_encode($json);
                wp_die();
            }
        }
    }

    /**
     * Get data from site ajax
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function get_data_from_site_ajax_callback()
    {
        // Kiểm tra nonce
        check_ajax_referer('mimi_admin_nonce', 'nonce');

        // Kiểm tra quyền của người dùng
        if (!current_user_can('manage_options')) {
            $json = array(
                "isSuccess"     => false,
            );

            echo wp_json_encode($json);
            wp_die();
        }

        if ($this->status_imported_data == 0) {

            $hasWoocommerce = 0;

            if (class_exists('WooCommerce')) {
                $hasWoocommerce = 1;
            }

            $apiKey = get_option(Keys::MIMI_API_KEY);
            $api_endpoint_import_all_datas          = MIMI_API_V1 . 'sites/import';
            $api_endpoint_import_related_products   = MIMI_API_RECOMMENDATION;
            $api_endpoint_bought_together           = MIMI_API_V1 . 'recommendations/frequent/init';
            $site = get_bloginfo('url', 'display');
            $title = get_bloginfo('name');
            $all_products = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::export_woocomerce_products();
            $all_posts = \VietDevelopers\MiMi\DataExport\WPPostsExport::export_WPPostsData();
            $all_orders = \VietDevelopers\MiMi\DataExport\WoocommerceProductsExport::export_woocomerce_orders();

            $allDatasFromSite = array(
                "site" => $site,
                "title" => $title,
                "products" => $all_products,
                "posts" => $all_posts,
            );

            $related_products = array(
                "site" => $site,
                "title" => $title,
                "products" => $all_products,
            );

            $bought_together =  array(
                "site" => $site,
                "title" => $title,
                "transactions" => $all_orders
            );

            $json = array(
                "isSuccess"                 => true,
                "hasWoocomerce"             => $hasWoocommerce,
                "apiKey"                    => $apiKey,
                "urlImportAllDatasFromSite" => $api_endpoint_import_all_datas,
                "urlImportRelatedProducts"  => $api_endpoint_import_related_products,
                "urlImportBoughtTogether"   => $api_endpoint_bought_together,
                "allDatasFromSite"          => $allDatasFromSite,
                "relatedProducts"           => $related_products,
                "boughtTogether"            => $bought_together
            );

            echo wp_json_encode($json);
            wp_die();
        }
    }

    /**
     * Update status imported data option ajax
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function update_status_imported_data_ajax_callback()
    {
        // Kiểm tra nonce
        check_ajax_referer('mimi_admin_nonce', 'nonce');

        // Kiểm tra quyền của người dùng
        if (!current_user_can('manage_options')) {
            $json = array(
                "isSuccess"     => false,
            );

            echo wp_json_encode($json);
            wp_die();
        }

        if ($this->status_imported_data == 0) {
            update_option(Keys::MIMI_STATUS_IMPORTED_DATA, 1);

            $json = array(
                "isSuccess" => true,
            );

            echo wp_json_encode($json);
            wp_die();
        }
    }
}
