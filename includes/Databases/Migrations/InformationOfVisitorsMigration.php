<?php

namespace VietDevelopers\MiMi\Databases\Migrations;

use VietDevelopers\MiMi\Abstracts\DBMigrator;
use VietDevelopers\MiMi\Common\WPDBTableNames;

/**
 * Information Of Visitors table Migration class.
 */
class InformationOfVisitorsMigration extends DBMigrator
{
    /**
     * Migrate the information_of_visitors table.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function migrate()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $table_name = $wpdb->prefix . WPDBTableNames::MIMI_INFORMATIONS_OF_VISITORS;

        $schema_information_of_visitors = "CREATE TABLE IF NOT EXISTS $table_name (
            `id` int(9) NOT NULL AUTO_INCREMENT,
            `visitor_id` varchar(50) NOT NULL,
            `fullname` varchar(100) NOT NULL,
            `email` varchar(50) NOT NULL,
            `phone_number` varchar(20) NOT NULL,
            `note` text NOT NULL,
            `joined_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `conversation_id` varchar(50) NOT NULL,
            PRIMARY KEY (`id`)
        ) $charset_collate;";

        // Create the table.
        dbDelta($schema_information_of_visitors);
    }

    /**
     * Drop the information_of_visitors table.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function drop()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . WPDBTableNames::MIMI_INFORMATIONS_OF_VISITORS;

        // Check table exists before deleteing
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
            // Delete the table
            $wpdb->query("DROP TABLE IF EXISTS $table_name");
        }
    }
}
