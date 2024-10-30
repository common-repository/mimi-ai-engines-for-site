<?php

namespace VietDevelopers\MiMi\AutomatedAIProjects;

use VietDevelopers\MiMi\Common\WPDBTableNames;

/**
 * AutomatedAIProject class
 * 
 * @since 1.1.0
 */
class Manager
{
    /**
     * Get all projects 
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_all_projects()
    {
        global $wpdb;

        // Lấy giá trị từ cache
        $cache_results = wp_cache_get('mimi_all_projects_results');

        $db_results = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM {$wpdb->prefix}mimi_automated_ai_projects")
        );

        if (false === $cache_results || $cache_results !== $db_results) {
            // Cập nhật cache nếu cache không tồn tại hoặc nếu giá trị khác với giá trị từ cơ sở dữ liệu
            wp_cache_set('mimi_all_projects_results', $db_results);
            $results = $db_results;
        } else {
            // Sử dụng dữ liệu từ cache nếu nó vẫn còn là mới nhất
            $results = $cache_results;
        }

        return $results;
    }

    /**
     * Get Target Audience by project_id
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_project_target_audiences($project_id)
    {
        global $wpdb;

        // Lấy giá trị từ cache
        $cache_results = wp_cache_get('mimi_automated_ai_project_target_audiences_results');

        $db_results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT audience_id FROM {$wpdb->prefix}mimi_automated_ai_project_target_audiences WHERE project_id = %d",
                $project_id
            )
        );

        if (false === $cache_results || $cache_results !== $db_results) {
            // Cập nhật cache nếu cache không tồn tại hoặc nếu giá trị khác với giá trị từ cơ sở dữ liệu
            wp_cache_set('mimi_automated_ai_project_target_audiences_results', $db_results);
            $results = $db_results;
        } else {
            // Sử dụng dữ liệu từ cache nếu nó vẫn còn là mới nhất
            $results = $cache_results;
        }

        return $results;
    }

    /**
     * Get value target audience by audience_id
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_target_audience($audience_id)
    {
        global $wpdb;

        // Lấy giá trị từ cache
        $cache_result = wp_cache_get('mimi_target_audiences_result');

        $db_result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}mimi_target_audiences WHERE id = %d",
                $audience_id
            )
        );

        if (false === $cache_result || $cache_result !== $db_result) {
            // Cập nhật cache nếu cache không tồn tại hoặc nếu giá trị khác với giá trị từ cơ sở dữ liệu
            wp_cache_set('mimi_target_audiences_result', $db_result);
            $result = $db_result;
        } else {
            // Sử dụng dữ liệu từ cache nếu nó vẫn còn là mới nhất
            $result = $cache_result;
        }

        return $result;
    }

    /**
     * Get landing page by project_id
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_landing_page($project_id)
    {
        global $wpdb;

        // Lấy giá trị từ cache
        $cache_result = wp_cache_get('mimi_landing_page_result');

        $db_result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}mimi_landing_pages WHERE project_id = %d",
                $project_id
            ),
        );

        if (false === $cache_result || $cache_result !== $db_result) {
            // Cập nhật cache nếu cache không tồn tại hoặc nếu giá trị khác với giá trị từ cơ sở dữ liệu
            wp_cache_set('mimi_landing_page_result', $db_result);
            $result = $db_result;
        } else {
            // Sử dụng dữ liệu từ cache nếu nó vẫn còn là mới nhất
            $result = $cache_result;
        }

        return $result;
    }

    /**
     * Get facebook ads config by project_id
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    public static function get_facebook_ads_config($project_id)
    {
        global $wpdb;

        // Lấy giá trị từ cache
        $cache_result = wp_cache_get('mimi_facebook_ads_config_result');

        $db_result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}mimi_automated_ai_project_facebook_ads_config WHERE project_id = %d",
                $project_id
            ),
        );

        if (false === $cache_result || $cache_result !== $db_result) {
            // Cập nhật cache nếu cache không tồn tại hoặc nếu giá trị khác với giá trị từ cơ sở dữ liệu
            wp_cache_set('mimi_landing_page_result', $db_result);
            $result = $db_result;
        } else {
            // Sử dụng dữ liệu từ cache nếu nó vẫn còn là mới nhất
            $result = $cache_result;
        }

        return $result;
    }

    /**
     * Insert a new record into MIMI_AUTOMATED_AI_PROJECTS.
     *
     * @since 1.1.0
     *
     * @param string $project_name
     * @param string $purpose
     * @param string $generate_content
     * @param string $type_of_product
     * @param string $status
     * @param string $project_start_date
     * @param string $project_end_date
     * @param string $products
     * @return int|false The ID of the inserted row, or false on error.
     */
    public static function insert_project($project_name, $purpose, $generate_content, $type_of_product, $status, $project_start_date, $project_end_date, $products)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . WPDBTableNames::MIMI_AUTOMATED_AI_PROJECTS;

        $data = [
            'project_name' => $project_name,
            'purpose' => $purpose,
            'generate_content' => $generate_content,
            'type_of_product' => $type_of_product,
            'status' => $status,
            'project_start_date' => $project_start_date,
            'project_end_date' => $project_end_date,
            'products' => $products
        ];

        $format = ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'];

        $inserted = $wpdb->insert($table_name, $data, $format);

        if ($inserted === false) {
            return false;
        }

        return $wpdb->insert_id;
    }

    /**
     * Insert a new record into MIMI_TARGET_AUDIENCES
     * 
     * @since 1.1.0
     * 
     * @param string $gender
     * @param string $age_range
     * @param string $interests
     * @param string $languages
     * @param string $countries
     * @return int|false The ID of the inserted row, or false on error.
     */
    public static function insert_target_audience($gender, $minimum_age, $maximum_age, $interests, $languages, $countries)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . WPDBTableNames::MIMI_TARGET_AUDIENCES;

        $data = [
            'gender' => $gender,
            'minimum_age' => $minimum_age,
            'maximum_age' => $maximum_age,
            'interests' => $interests,
            'languages' => $languages,
            'countries' => $countries
        ];

        $format = ['%s', '%d', '%d', '%s', '%s', '%s'];

        $inserted = $wpdb->insert($table_name, $data, $format);

        if ($inserted === false) {
            return false;
        }

        return $wpdb->insert_id;
    }

    /**
     * Insert a new record into MIMI_LANDING_PAGES
     * 
     * @param string $page_id
     * @param string $url
     * @param string $file_name
     * @param string $fileURL
     * @return int|false The ID of the inserted row, or false on error.
     */
    public static function insert_landing_page($page_id, $url, $file_name, $fileURL, $project_id)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . WPDBTableNames::MIMI_LANDING_PAGES;

        $data = [
            'page_id' => $page_id,
            'url' => $url,
            'file_name' => $file_name,
            'fileURL' => $fileURL,
            'project_id' => $project_id
        ];

        $format = ['%s', '%s', '%s', '%s', '%d'];

        $inserted = $wpdb->insert($table_name, $data, $format);

        if ($inserted === false) {
            return false;
        }

        return $wpdb->insert_id;
    }

    /**
     * Insert a new record into MIMI_AUTOMATED_AI_PROJECT_TARGET_AUDIENCES
     * 
     * @param int $project_id
     * @param int $target_audience_id
     * @return int|false The ID of the inserted row, or false on error.
     */
    public static function insert_project_target_audiences($project_id, $target_audience_id)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . WPDBTableNames::MIMI_AUTOMATED_AI_PROJECT_TARGET_AUDIENCES;

        $data = [
            'project_id' => $project_id,
            'audience_id' => $target_audience_id
        ];

        $format = ['%d', '%d'];

        $inserted = $wpdb->insert($table_name, $data, $format);

        if ($inserted === false) {
            return false;
        }

        return $wpdb->insert_id;
    }

    /**
     * Insert a new record into MIMI_AUTOMATED_AI_PROJECT_FACEBOOK_ADS_CONFIG
     * 
     * @param int project_id
     * @param string type_of_budget
     * @param string amount
     * @param string start_date
     * @param string end_date
     * @param string daily_minimum_amount
     * @param string daily_maximum_amount
     * @param string ads_post_content
     */
    public static function insert_facebook_ads_config($project_id, $type_of_budget, $amount, $start_date, $end_date, $daily_minimum_amount, $daily_maximum_amount, $ads_post_content)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . WPDBTableNames::MIMI_AUTOMATED_AI_PROJECT_FACEBOOK_ADS_CONFIG;

        $data = [
            'project_id' => $project_id,
            'type_of_budget' => $type_of_budget,
            'amount' => $amount,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'daily_minimum_amount' => $daily_minimum_amount,
            'daily_maximum_amount' => $daily_maximum_amount,
            'ads_post_content' => $ads_post_content
        ];

        $format = ['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s'];

        $inserted = $wpdb->insert($table_name, $data, $format);

        if ($inserted === false) {
            return false;
        }

        return $wpdb->insert_id;
    }
}
