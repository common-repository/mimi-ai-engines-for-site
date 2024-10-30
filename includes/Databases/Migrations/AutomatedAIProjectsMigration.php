<?php

namespace VietDevelopers\MiMi\Databases\Migrations;

use VietDevelopers\MiMi\Abstracts\DBMigrator;
use VietDevelopers\MiMi\Common\WPDBTableNames;

/**
 * Automated AI projects table Migration class
 */
class AutomatedAIProjectsMigration extends DBMigrator
{
    /**
     * Migrate the automated_ai_projects, 
     * target_audiences, automated_ai_project_target_audiences, 
     * landing_pages, automated_ai_project_landing_pages, automated_ai_project_facebook_ads_config table.
     *
     * @since 1.1.0
     *
     * @return void
     */
    public static function migrate()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // mimi_automated_ai_projects table
        $automated_ai_projects_table_name = $wpdb->prefix . WPDBTableNames::MIMI_AUTOMATED_AI_PROJECTS;
        $schema_automated_ai_projects = "CREATE TABLE IF NOT EXISTS $automated_ai_projects_table_name (
            `id` int(9) NOT NULL AUTO_INCREMENT,
            `project_name` varchar(255) NOT NULL,
            `purpose` varchar(50) NOT NULL,
            `generate_content` varchar(255) NOT NULL,
            `type_of_product` varchar(255) NOT NULL,
            `status` varchar(20) NOT NULL,
            `project_start_date` date NOT NULL,
            `project_end_date` date NOT NULL,
            `products` longtext NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";
        dbDelta($schema_automated_ai_projects);

        // mimi_target_audiences table
        $target_audiences_table_name = $wpdb->prefix . WPDBTableNames::MIMI_TARGET_AUDIENCES;
        $schema_target_audiences = "CREATE TABLE IF NOT EXISTS $target_audiences_table_name (
            `id` int(9) NOT NULL AUTO_INCREMENT,
            `gender` varchar(25) NOT NULL,
            `minimum_age` varchar(25) NOT NULL,
            `maximum_age` varchar(25) NOT NULL,
            `interests` longtext NOT NULL,
            `languages` longtext NOT NULL,
            `countries` longtext NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";
        dbDelta($schema_target_audiences);

        // mimi_automated_ai_project_target_audiences
        $automated_ai_project_target_audiences_table_name = $wpdb->prefix . WPDBTableNames::MIMI_AUTOMATED_AI_PROJECT_TARGET_AUDIENCES;
        $schema_automated_ai_project_target_audiences = "CREATE TABLE IF NOT EXISTS $automated_ai_project_target_audiences_table_name (
            `id` int(9) NOT NULL AUTO_INCREMENT,
            `project_id` int(9) NOT NULL,
            `audience_id` int(9) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`),
            KEY `audience_id` (`audience_id`)
        ) $charset_collate;";
        dbDelta($schema_automated_ai_project_target_audiences);

        // mimi_landing_pages table
        $landing_pages_table_name = $wpdb->prefix . WPDBTableNames::MIMI_LANDING_PAGES;
        $schema_landing_pages = "CREATE TABLE IF NOT EXISTS $landing_pages_table_name (
            `id` int(9) NOT NULL AUTO_INCREMENT,
            `page_id` varchar(255) NOT NULL,
            `url` varchar(255) NOT NULL,
            `file_name` varchar(255) NOT NULL,
            `fileURL` varchar(255) NOT NULL,
            `project_id` int(9) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`)
        ) $charset_collate;";
        dbDelta($schema_landing_pages);

        // mimi_automated_ai_project_facebook_ads_config table
        $automated_ai_project_facebook_ads_config_table_name = $wpdb->prefix . WPDBTableNames::MIMI_AUTOMATED_AI_PROJECT_FACEBOOK_ADS_CONFIG;
        $schema_automated_ai_project_facebook_ads_config = "CREATE TABLE IF NOT EXISTS $automated_ai_project_facebook_ads_config_table_name (
            `id` int(9) NOT NULL AUTO_INCREMENT,
            `project_id` int(9) NOT NULL,
            `type_of_budget` varchar(50) NOT NULL,
            `amount` varchar(25) NOT NULL,
            `start_date` date NOT NULL,
            `end_date` date NOT NULL,
            `daily_minimum_amount` varchar(50) NOT NULL,
            `daily_maximum_amount` varchar(50) NOT NULL,
            `ads_post_content` longtext NOT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`)
        ) $charset_collate;";
        dbDelta($schema_automated_ai_project_facebook_ads_config);
    }

    /**
     * Drop the automated_ai_projects table.
     *
     * @since 1.1.0
     *
     * @return void
     */
    public static function drop()
    {
        global $wpdb;

        $tables = [
            WPDBTableNames::MIMI_AUTOMATED_AI_PROJECTS,
            WPDBTableNames::MIMI_TARGET_AUDIENCES,
            WPDBTableNames::MIMI_AUTOMATED_AI_PROJECT_TARGET_AUDIENCES,
            WPDBTableNames::MIMI_LANDING_PAGES,
            WPDBTableNames::MIMI_AUTOMATED_AI_PROJECT_LANDING_PAGES,
            WPDBTableNames::MIMI_AUTOMATED_AI_PROJECT_FACEBOOK_ADS_CONFIG
        ];

        foreach ($tables as $table) {
            $table_name = $wpdb->prefix . $table;

            // Check table exists before deleting
            if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
                // Delete the table
                $wpdb->query("DROP TABLE IF EXISTS $table_name");
            }
        }
    }
}
