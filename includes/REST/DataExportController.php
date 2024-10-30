<?php

namespace VietDevelopers\MiMi\REST;

use VietDevelopers\MiMi\Abstracts\RESTController;

use WP_REST_Server;
use WP_Error;
use WP_REST_Response;
use VietDevelopers\MiMi\Traits\InputSanitizer;

/**
 * API DataExportController class.
 *
 * @since 1.0.0
 */
class DataExportController extends RESTController
{
    use InputSanitizer;

    /**
     * Route base.
     *
     * @var string
     */
    protected $base = 'data-export';

    /**
     * Register all routes related with carts.
     *
     * @return void
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/all',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'wordpress_data_export'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/products',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'products_data_export'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/product-orders',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'product_orders_data_export'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/best-selling-products',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'best_selling_products_export'],
                    'permission_callback'   => [$this, 'check_permission'],
                    'args'                  => $this->get_collection_params()
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/newest-products',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'newest_products_export'],
                    'permission_callback'   => [$this, 'check_permission'],
                    'args'                  => $this->get_collection_params()
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/instock-products',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'in_stock_products_export'],
                    'permission_callback'   => [$this, 'check_permission'],
                    'args'                  => $this->get_collection_params()
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/paginated-products',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'paginated_products_export'],
                    'permission_callback'   => [$this, 'check_permission'],
                    'args'                  => $this->get_collection_params()
                ]
            ]
        );
    }

    /**
     * check permission
     *
     * @since 1.0.0
     * 
     * @return bool
     */
    public function check_permission(): bool
    {
        // return current_user_can('manage_options');

        return true;
    }

    /**
     * Retrieves a collection of pages, post and products.
     *
     * @since 1.0.0
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function wordpress_data_export()
    {
        $all_datas_from_site = \VietDevelopers\MiMi\DataExport\Manager::export_all_datas();

        if (!$all_datas_from_site) {
            return new WP_Error('mimi_data_export_fail', __('Data have not been successfully exported', 'mimi'), ['status' => 400]);
        }

        $response = array(
            'status' => 'success',
            'message' => __('Data have been successfully exported', 'mimi'),
            'data' => $all_datas_from_site
        );

        return rest_ensure_response($response);
    }

    /**
     * Retrieves a collection of products.
     *
     * @since 1.0.0
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function products_data_export()
    {
        $products_datas_from_site = \VietDevelopers\MiMi\DataExport\Manager::export_only_products();

        if (!$products_datas_from_site) {
            return new WP_Error('mimi_products_data_export_fail', __('Data have not been successfully exported', 'mimi'), ['status' => 400]);
        }

        $response = array(
            'status' => 'success',
            'message' => __('Products data have been successfully exported', 'mimi'),
            'data' => $products_datas_from_site
        );

        return rest_ensure_response($response);
    }

    /**
     * Retrieves a collection of products orders.
     *
     * @since 1.0.0
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function product_orders_data_export()
    {
        $orders_datas_from_site = \VietDevelopers\MiMi\DataExport\Manager::export_all_orders();

        if (!$orders_datas_from_site) {
            return new WP_Error('mimi_orders_data_export_fail', __('Data have not been successfully exported', 'mimi'), ['status' => 400]);
        }

        $response = array(
            'status' => 'success',
            'message' => __('Product orders data have been successfully exported', 'mimi'),
            'data' => $orders_datas_from_site
        );

        return rest_ensure_response($response);
    }

    /**
     * Retrieves a collection of best selling products.
     *
     * @since 1.1.0
     * 
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function best_selling_products_export($request): ?WP_REST_Response
    {
        $args = [];
        $params = $this->get_collection_params();

        foreach ($params as $key => $value) {
            if (isset($request[$key])) {
                $args[$key] = $request[$key];
            }
        }

        $limit = $this->sanitize((int) $args['limit'], 'number');

        $best_selling_products_data = \VietDevelopers\MiMi\DataExport\Manager::export_best_sellings_products($limit);

        $response = array(
            'status' => 'success',
            'message' => __('Best selling products have been successfully exported', 'mimi'),
            'data' => $best_selling_products_data
        );

        return rest_ensure_response($response);
    }

    /**
     * Retrieves a collection of paginated products.
     *
     * @since 1.1.0
     * 
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function paginated_products_export($request): ?WP_REST_Response
    {
        $args = [];
        $params = $this->get_collection_params();

        foreach ($params as $key => $value) {
            if (isset($request[$key])) {
                $args[$key] = $request[$key];
            }
        }

        $paged = $this->sanitize((int) $args['paged'], 'number');
        $limit = $this->sanitize((int) $args['limit'], 'number');
        $search_query = $this->sanitize($args['search_query'], 'text');

        $paginated_products_data = \VietDevelopers\MiMi\DataExport\Manager::export_paginated_products($limit, $paged, $search_query);

        $response = array(
            'status' => 'success',
            'message' => __('Paginated products have been successfully exported', 'mimi'),
            'data' => $paginated_products_data['products'],
            'total_pages' => $paginated_products_data['total_pages']
        );

        return rest_ensure_response($response);
    }

    /**
     * Retrieves a collection of newest products.
     *
     * @since 1.1.0
     * 
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function newest_products_export($request): ?WP_REST_Response
    {
        $args = [];
        $params = $this->get_collection_params();

        foreach ($params as $key => $value) {
            if (isset($request[$key])) {
                $args[$key] = $request[$key];
            }
        }

        $limit = $this->sanitize((int) $args['limit'], 'number');

        $newest_products_data = \VietDevelopers\MiMi\DataExport\Manager::export_newest_products($limit);

        $response = array(
            'status' => 'success',
            'message' => __('Newest products have been successfully exported', 'mimi'),
            'data' => $newest_products_data
        );

        return rest_ensure_response($response);
    }

    /**
     * Retrieves a collection of in-stock products.
     *
     * @since 1.1.0
     * 
     * @param WP_REST_Request $request Full details about the request.
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function in_stock_products_export($request): ?WP_REST_Response
    {
        $args = [];
        $params = $this->get_collection_params();

        foreach ($params as $key => $value) {
            if (isset($request[$key])) {
                $args[$key] = $request[$key];
            }
        }

        $limit = $this->sanitize((int) $args['limit'], 'number');

        $in_stock_products_data = \VietDevelopers\MiMi\DataExport\Manager::export_in_stock_products($limit);

        $response = array(
            'status' => 'success',
            'message' => __('In stock products have been successfully exported', 'mimi'),
            'data' => $in_stock_products_data
        );

        return rest_ensure_response($response);
    }

    /**
     * Retrieves the query params for collections.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_collection_params(): array
    {
        $params = parent::get_collection_params();

        $params['limit']['default'] = 5;
        $params['paged']['default'] = 1;
        $params['search_query']['default'] = '';

        return $params;
    }
}
