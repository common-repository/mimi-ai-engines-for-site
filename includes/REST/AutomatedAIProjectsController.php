<?php

namespace VietDevelopers\MiMi\REST;

use VietDevelopers\MiMi\Abstracts\RESTController;

use WP_REST_Server;
use WP_Error;
use WP_REST_Response;
use VietDevelopers\MiMi\Traits\InputSanitizer;
use VietDevelopers\MiMi\Common\Keys;
use WC_Countries;
use WP_Query;

/**
 * API AutomatedAIProjects class.
 *
 * @since 1.1.0
 */
class AutomatedAIProjectsController extends RESTController
{
    use InputSanitizer;

    /**
     * Route base.
     *
     * @var string
     */
    protected $base = 'automated-ai';

    /**
     * Register all routes related with carts.
     *
     * @return void
     */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/landing-page',
            [
                [
                    'methods'               => WP_REST_Server::CREATABLE,
                    'callback'              => [$this, 'generate_landing_page'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/ads-audiences',
            [
                [
                    'methods'               => WP_REST_Server::CREATABLE,
                    'callback'              => [$this, 'generate_ads_audiences'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/landing-page',
            [
                [
                    'methods'               => WP_REST_Server::DELETABLE,
                    'callback'              => [$this, 'delete_landing_page'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/projects',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'get_all_projects'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/projects',
            [
                [
                    'methods'               => WP_REST_Server::CREATABLE,
                    'callback'              => [$this, 'insert_new_project'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/projects/(?P<project_id>\d+)',
            [
                [
                    'methods'               => WP_REST_Server::READABLE,
                    'callback'              => [$this, 'get_all_data_projects'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/' . $this->base . '/projects/ads-config',
            [
                [
                    'methods'               => WP_REST_Server::CREATABLE,
                    'callback'              => [$this, 'insert_audiences_and_ads_config'],
                    'permission_callback'   => [$this, 'check_permission'],
                ]
            ]
        );
    }

    /**
     * Check permission
     *
     * @return bool
     */
    public function check_permission(): bool
    {
        // return current_user_can('manage_options');
        return true;
    }

    /**
     * Sanitize the input array
     *
     * @param array $data
     * @return array
     */
    private function sanitizeProducts(array $data)
    {
        // Function to sanitize each value based on its expected type
        foreach ($data as $key => &$value) {
            if (is_array($value)) {
                // Recursively sanitize arrays
                $value = $this->sanitizeProducts($value);
            } else {
                switch ($key) {
                    case "id":
                    case "originalPrice":
                    case "salePrice":
                        // Ensure these are integers
                        $value = $this->sanitize($value, 'number');
                        break;
                    case "isForSale":
                        $value = $this->sanitize($value, 'boolean');
                        break;
                    default:
                        // Default sanitization for any other types
                        $value = $this->sanitize($value, 'text');
                        break;
                }
            }
        }
        return $data;
    }

    // private function sanitize

    /**
     * Get all projects
     * 
     * @since 1.1.0
     * 
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_all_projects()
    {
        $results = \VietDevelopers\MiMi\AutomatedAIProjects\Manager::get_all_projects();

        return rest_ensure_response(
            [
                'isSuccess' => 1,
                'message'   => __('Get all projects succesfully.', 'mimi'),
                'data'      => $results
            ]
        );
    }

    /**
     * Get all data projects
     * 
     * @since 1.1.0
     * 
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function get_all_data_projects($request)
    {
        $project_id = intval($request['project_id']);

        $audiences = \VietDevelopers\MiMi\AutomatedAIProjects\Manager::get_project_target_audiences($project_id);

        $audiences_data = [];
        foreach ($audiences as $audience) {
            $audience_details = \VietDevelopers\MiMi\AutomatedAIProjects\Manager::get_target_audience($audience->audience_id);
            if ($audience_details) {
                $audiences_data[] = [
                    'gender'      => json_decode($audience_details->gender),
                    'minimumAge'  => $audience_details->minimum_age,
                    'maximumAge'  => $audience_details->maximum_age,
                    'interests'   => json_decode($audience_details->interests),
                    'languages'   => json_decode($audience_details->languages),
                    'countries'   => json_decode($audience_details->countries),
                ];
            }
        }

        $landing_page = \VietDevelopers\MiMi\AutomatedAIProjects\Manager::get_landing_page($project_id);
        $landing_page_data = [
            'idPage'    => $landing_page->page_id,
            'url'       => $landing_page->url,
            'fileName'  => $landing_page->file_name,
            'fileURL'   => $landing_page->fileURL,
        ];

        $ads_config = \VietDevelopers\MiMi\AutomatedAIProjects\Manager::get_facebook_ads_config($project_id);
        $ads_config_data = [
            'type_of_budget'        => $ads_config->type_of_budget,
            'amount'                => $ads_config->amount,
            'project_start_date'    => $ads_config->start_date,
            'project_end_date'      => $ads_config->end_date,
            'daily_minimum_amount'  => $ads_config->daily_minimum_amount,
            'daily_maximum_amount'  => $ads_config->daily_maximum_amount,
            'ads_post_content'      => $ads_config->ads_post_content,
        ];

        return rest_ensure_response(
            [
                'isSuccess' => 1,
                'message'   => __('Get all data projects succesfully.', 'mimi'),
                'data'      => [
                    'audiences'     => $audiences_data,
                    'landing_page'  => $landing_page_data,
                    'ads_config'    => $ads_config_data,
                ]
            ]
        );
    }

    /**
     * Insert a new project
     *
     * @since 1.1.0
     * 
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function insert_new_project($request)
    {
        $project_name       = $this->sanitize($request['project_name'], 'text');
        $purpose            = $this->sanitize($request['purpose'], 'text');
        $generate_content   = $this->sanitize($request['generate_content'], 'text');
        $type_of_product    = $this->sanitize($request['type_of_product'], 'text');
        $status             = $this->sanitize($request['status'], 'text');
        $project_start_date = $this->sanitize($request['project_start_date'], 'text');
        $project_end_date   = $this->sanitize($request['project_end_date'], 'text');
        $products           = wp_json_encode($this->sanitizeProducts($request['products']));

        $project_id = \VietDevelopers\MiMi\AutomatedAIProjects\Manager::insert_project(
            $project_name,
            $purpose,
            $generate_content,
            $type_of_product,
            $status,
            $project_start_date,
            $project_end_date,
            $products
        );

        if ($project_id) {
            return rest_ensure_response(
                [
                    'isSuccess' => 1,
                    'message'   => __('Create Automated AI project succesfully.', 'mimi'),
                    'data'      => array(
                        'project_id' => $project_id,
                    )
                ]
            );
        }
    }

    /**
     * Insert audiences and ads config
     *
     * @since 1.1.0
     * 
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function insert_audiences_and_ads_config($request)
    {
        $project_id             = $this->sanitize($request['project_id'], 'number');
        $project_start_date     = $this->sanitize($request['project_start_date'], 'text');
        $project_end_date       = $this->sanitize($request['project_end_date'], 'text');
        $audiences              = is_array($request['audiences']) ? $request['audiences'] : array();
        $page_id                = $this->sanitize($request['page_id'], 'number');
        $page_url               = $this->sanitize($request['page_url'], 'text');
        $file_name              = $this->sanitize($request['file_name'], 'text');
        $file_url               = $this->sanitize($request['file_url'], 'text');
        $type_of_budget         = $this->sanitize($request['type_of_budget'], 'text');
        $amount                 = $this->sanitize($request['amount'], 'text');
        $daily_minimum_amount   = $this->sanitize($request['daily_minimum_amount'], 'text');
        $daily_maximum_amount   = $this->sanitize($request['daily_maximum_amount'], 'text');
        $ads_post_content       = $this->sanitize($request['ads_post_content'], 'text');

        foreach ($audiences as $audience) {
            $gender         = wp_json_encode($this->sanitize($audience['gender'], 'array_text'));
            $minimum_age    = $this->sanitize($audience['minimum_age'], 'number');
            $maximum_age    = $this->sanitize($audience['maximum_age'], 'number');
            $interests      = wp_json_encode($this->sanitize($audience['interests'], 'array_text'));
            $languages      = wp_json_encode($this->sanitize($audience['languages'], 'array_text'));
            $countries      = wp_json_encode($this->sanitize($audience['countries'], 'array_text'));

            $audience_id = \VietDevelopers\MiMi\AutomatedAIProjects\Manager::insert_target_audience($gender, $minimum_age, $maximum_age, $interests, $languages, $countries);

            if ($audience_id) {
                \VietDevelopers\MiMi\AutomatedAIProjects\Manager::insert_project_target_audiences($project_id, $audience_id);
            }
        }

        \VietDevelopers\MiMi\AutomatedAIProjects\Manager::insert_landing_page(
            $page_id,
            $page_url,
            $file_name,
            $file_url,
            $project_id
        );

        \VietDevelopers\MiMi\AutomatedAIProjects\Manager::insert_facebook_ads_config(
            $project_id,
            $type_of_budget,
            $amount,
            $project_start_date,
            $project_end_date,
            $daily_minimum_amount,
            $daily_maximum_amount,
            $ads_post_content
        );

        return rest_ensure_response(
            [
                'isSuccess' => 1,
                'message'   => __('Insert audiences and ads config to automated ai project succesfully.', 'mimi'),
            ]
        );
    }

    /**
     * Retrieves ads audiences.
     *
     * @since 1.1.0
     * 
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function generate_ads_audiences($request)
    {
        if (!class_exists('WooCommerce')) {
            return new WP_Error('mimi_automated_ai_generate_ads_audiences_dont_have_woocommerce', __("This site don't have WooCommerce plugin", 'mimi'), ['status' => 400]);
        }

        $projectID          = $this->sanitize($request['projectID'], 'number');
        $adsTarget          = $this->sanitize($request['adsTarget'], 'text');
        $numberOfAudiences  = $this->sanitize($request['numberOfAudiences'], 'number');
        $sellingCurrencies  = array(get_woocommerce_currency());
        $sellingLocations   = $this->get_selling_locations();
        $products           = is_array($request['products']) ? $request['products'] : array();
        $products_sanitize  = $this->sanitizeProducts($products);

        $productsForAPI = array();

        foreach ($products_sanitize as $product) {
            $product_id     = $this->sanitize($product['id'], 'number');
            $originalPrice  = $this->sanitize($product['originalPrice'], 'number');
            $isForSale      = $this->sanitize($product['isForSale'], 'switch');
            $salePrice      = $this->sanitize($product['salePrice'], 'number');

            $productsForAPI[] = \VietDevelopers\MiMi\DataExport\Manager::export_product_detail($product_id, $originalPrice, $isForSale, $salePrice);
        }

        $data_body = array(
            "projectID"         => $projectID,
            "adsTarget"         => $adsTarget,
            "numberOfAudiences" => $numberOfAudiences,
            "sellingCurrencies" => $sellingCurrencies,
            "sellingLocations"  => $sellingLocations,
            "products"          => $productsForAPI
        );

        $keyAPI = get_option(Keys::MIMI_API_KEY);

        $args = array(
            'timeout' => 10,
            'headers' => array(
                'Content-Type'  => 'application/json',
                'x-api-key'     => $keyAPI
            ),
            'body' => wp_json_encode($data_body)
        );

        $api_url = MIMI_API_V1 . 'automate/audiences';

        $response = wp_remote_post($api_url, $args);

        if (isset($response)) {
            $body = wp_remote_retrieve_body($response);
            $body_decode = json_decode($body);

            if ($body_decode->isSuccess === true) {
                $audiences = $body_decode->data->audiences;

                return rest_ensure_response(
                    [
                        'isSuccess' => 1,
                        'message'   => __('Generate ads audiences succesfully.', 'mimi'),
                        'data'      => $audiences
                    ]
                );
            }
        }
    }

    /**
     * Generate landing page
     * 
     * @since 1.1.0
     * 
     * @param WP_Rest_Request $request
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function generate_landing_page($request)
    {
        if (!class_exists('WooCommerce')) {
            return new WP_Error('mimi_automated_ai_generate_landing_page_dont_have_woocommerce', __("This site don't have WooCommerce plugin", 'mimi'), ['status' => 400]);
        }

        $projectID              = $this->sanitize($request['projectID'], 'number');
        $projectName            = $this->sanitize($request['projectName'], 'text');
        $purposeOfProject       = $this->sanitize($request['purposeOfProject'], 'text');
        $genrateContentFor      = $this->sanitize($request['genrateContentFor'], 'text');
        $numberOfPageGenrate    = $this->sanitize($request['numberOfPageGenrate'], 'number');
        $adsTarget              = $this->sanitize($request['adsTarget'], 'text');
        $numberOfAudiences      = $this->sanitize($request['numberOfAudiences'], 'number');
        $sellingCurrencies      = array(get_woocommerce_currency());
        $sellingLocations       = $this->get_selling_locations();

        $products               = is_array($request['products']) ? $request['products'] : array();
        $products_sanitize      = $this->sanitizeProducts($products);

        $productsForAPI = array();

        foreach ($products_sanitize as $product) {
            $product_id     = $this->sanitize($product['id'], 'number');
            $originalPrice  = $this->sanitize($product['originalPrice'], 'number');
            $isForSale      = $this->sanitize($product['isForSale'], 'switch');
            $salePrice      = $this->sanitize($product['salePrice'], 'number');

            $productsForAPI[] = \VietDevelopers\MiMi\DataExport\Manager::export_product_detail($product_id, $originalPrice, $isForSale, $salePrice);
        }

        $productsToView = array();

        foreach ($products_sanitize as $product) {
            $product_id     = $this->sanitize($product['id'], 'number');
            $originalPrice  = $this->sanitize($product['originalPrice'], 'number');
            $isForSale      = $this->sanitize($product['isForSale'], 'switch');
            $salePrice      = $this->sanitize($product['salePrice'], 'number');

            $productsToView[] = \VietDevelopers\MiMi\DataExport\Manager::export_product_detail_to_view($product_id, $originalPrice, $isForSale, $salePrice);
        }

        $data_body = array(
            "projectID"             => $projectID,
            "purposeOfProject"      => $purposeOfProject,
            "genrateContentFor"     => $genrateContentFor,
            "numberOfPageGenrate"   => $numberOfPageGenrate,
            "adsTarget"             => $adsTarget,
            "numberOfAudiences"     => $numberOfAudiences,
            "sellingCurrencies"     => $sellingCurrencies,
            "sellingLocations"      => $sellingLocations,
            "products"              => $productsForAPI
        );

        $keyAPI = get_option(Keys::MIMI_API_KEY);

        $args = array(
            'timeout' => 10,
            'headers' => array(
                'Content-Type' => 'application/json',
                'x-api-key' => $keyAPI
            ),
            'body' => wp_json_encode($data_body)
        );

        $api_url = MIMI_API_V1 . 'automate/landingpages';
        $response = wp_remote_post($api_url, $args);

        if (isset($response)) {
            $body = wp_remote_retrieve_body($response);
            $body_decode = json_decode($body);

            if ($body_decode->isSuccess === true) {
                $templates = $body_decode->data->templates;

                $data = array();

                foreach ($templates as $template) {

                    $style = "mimi-landing-page-style-" . $template->templateID;

                    $title = $projectName . ' campaign ' . $template->templateID;
                    $template = 'LandingPageApp.php';
                    $dataForTemplate = array(
                        'style' => $style,
                        'genrateContentFor' => $genrateContentFor,
                        'products' => $productsToView
                    );

                    $query = new WP_Query(
                        array(
                            'post_type' => 'page',
                            'title' => $title,
                            'posts_per_page' => 1
                        )
                    );

                    if (!$query->have_posts()) {
                        $new_page_id = wp_insert_post(
                            array(
                                'post_title'    => $title,
                                'post_content'  => '',
                                'post_status'   => 'publish',
                                'post_author'   => 1,
                                'post_type'     => 'page',
                                'post_name'     => $title,
                                'comment_status' => 'closed',
                                'ping_status'   => 'closed',
                                'post_category' => array(1)
                            )
                        );

                        if (!is_wp_error($new_page_id)) {
                            update_post_meta($new_page_id, '_wp_page_template', $template);
                            update_post_meta($new_page_id, 'mimi_data_template', $dataForTemplate);

                            $page_url = get_permalink($new_page_id);

                            $data_body_capture = array(
                                "siteURL" => $page_url
                            );

                            $argsCapture = array(
                                //                                 'timeout' => 10,
                                'headers' => array(
                                    'Content-Type' => 'application/json',
                                    'x-api-key' => $keyAPI
                                ),
                                'body' => wp_json_encode($data_body_capture)
                            );

                            $api_capture_url = MIMI_API_V1 . 'automate/landingpages/images';
                            $response = wp_remote_post($api_capture_url, $argsCapture);
                            if (isset($response)) {
                                $body = wp_remote_retrieve_body($response);
                                $body_decode = json_decode($body);

                                if ($body_decode->isSuccess === true) {
                                    $dataImage = $body_decode->data;
                                    $fileName = $dataImage->fileName;
                                    $fileURL = $dataImage->fileURL;

                                    $data[] = array(
                                        'idPage' => $new_page_id,
                                        'url' => $page_url,
                                        'fileName' => $fileName,
                                        'fileURL' => $fileURL
                                    );

                                    // // Array of parameters to update the post
                                    // $page_data = array(
                                    //     'ID'           => $new_page_id,
                                    //     'post_status'  => 'draft'
                                    // );

                                    // // Update the page, set the status to draft
                                    // wp_update_post($page_data);
                                }
                            }
                        }
                    } else {
                        wp_delete_post($page_check->ID, true);

                        $new_page_id = wp_insert_post(
                            array(
                                'post_title'    => $title,
                                'post_content'  => '',
                                'post_status'   => 'publish',
                                'post_author'   => 1,
                                'post_type'     => 'page',
                                'post_name'     => $title,
                                'comment_status' => 'closed',
                                'ping_status'   => 'closed',
                                'post_category' => array(1)
                            )
                        );

                        update_post_meta($new_page_id, '_wp_page_template', $template);
                        update_post_meta($new_page_id, 'mimi_data_template', $dataForTemplate);

                        $page_url = get_permalink($new_page_id);

                        $data_body_capture = array(
                            "siteURL" => $page_url
                        );

                        $argsCapture = array(
                            //                             'timeout' => 10,
                            'headers' => array(
                                'Content-Type' => 'application/json',
                                'x-api-key' => $keyAPI
                            ),
                            'body' => wp_json_encode($data_body_capture)
                        );

                        $api_capture_url = MIMI_API_V1 . 'automate/landingpages/images';
                        $response = wp_remote_post($api_capture_url, $argsCapture);
                        if (isset($response)) {
                            $body = wp_remote_retrieve_body($response);
                            $body_decode = json_decode($body);

                            if ($body_decode->isSuccess === true) {
                                $dataImage = $body_decode->data;
                                $fileName = $dataImage->fileName;
                                $fileURL = $dataImage->fileURL;

                                $data[] = array(
                                    'idPage' => $new_page_id,
                                    'url' => $page_url,
                                    'fileName' => $fileName,
                                    'fileURL' => $fileURL
                                );

                                // // Array of parameters to update the post
                                // $page_data = array(
                                //     'ID'           => $new_page_id,
                                //     'post_status'  => 'draft'
                                // );

                                // // Update the page, set the status to draft
                                // wp_update_post($page_data);
                            }
                        }
                    }
                }

                return rest_ensure_response(
                    [
                        'isSuccess' => 1,
                        'message' => __('Generate landing page succesfully.', 'mimi'),
                        'data' => $data
                    ]
                );
            }
        }
    }

    public function delete_landing_page($request)
    {
        $projectIDs = $this->sanitize($request['ids'], 'array_number');

        foreach ($projectIDs as $projectID) {
            wp_delete_post($projectID, true);
        }

        return rest_ensure_response(
            [
                'isSuccess' => 1,
                'message' => __('Delete landing page succesfully.', 'mimi'),
            ]
        );
    }

    private function get_selling_locations()
    {
        // Thiết lập locale mặc định là en_US
        $locale = 'en_US';
        switch_to_locale($locale);

        // Lấy tùy chọn địa điểm bán hàng
        $selling_locations = get_option('woocommerce_allowed_countries');

        // Lớp WC_Countries để lấy thông tin quốc gia
        $countries_obj = new WC_Countries();
        $all_countries = $countries_obj->get_countries();

        // Nếu địa điểm bán hàng là "all", trả về danh sách tất cả các quốc gia
        if ($selling_locations === 'all') {
            return array("global");
        }

        // Nếu là các quốc gia cụ thể, trả về danh sách các quốc gia cụ thể
        if ($selling_locations === 'specific') {
            $specific_countries = get_option('woocommerce_specific_allowed_countries');
            $specific_country_names = [];

            foreach ($specific_countries as $country_code) {
                if (isset($all_countries[$country_code])) {
                    $specific_country_names[] = $all_countries[$country_code];
                }
            }
            return $specific_country_names;
        }

        // Nếu địa điểm bán hàng là "all_except", trả về danh sách các quốc gia ngoại trừ các quốc gia bị loại trừ
        if ($selling_locations === 'all_except') {
            $excluded_countries = get_option('woocommerce_all_except_countries');
            $allowed_country_names = [];

            foreach ($all_countries as $country_code => $country_name) {
                if (!in_array($country_code, $excluded_countries)) {
                    $allowed_country_names[] = $country_name;
                }
            }
            return $allowed_country_names;
        }

        // Khôi phục lại locale mặc định
        restore_previous_locale();

        // Các trường hợp khác, trả về mảng rỗng
        return array();
    }
}
