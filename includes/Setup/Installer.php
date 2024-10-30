<?php

namespace VietDevelopers\MiMi\Setup;

use VietDevelopers\MiMi\Common\Keys;

/**
 * Class Installer.
 *
 * Install necessary database tables and options for the plugin.
 */
class Installer
{

    /**
     * Run the installer.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function run(): void
    {
        // Update the installed version.
        $this->add_version();

        // create tables.
        $this->create_tables();

        // Run the database seeders.
        // $seeder = new \VietDevelopers\MiMi\Databases\Seeder\Manager();
        // $seeder->run();

        // Add wordpress options
        $this->add_options();
    }

    /**
     * Add time and version on DB.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function add_version(): void
    {
        $installed = get_option(Keys::MIMI_INSTALLED);

        if (!$installed) {
            update_option(Keys::MIMI_INSTALLED, time());
        }

        update_option(Keys::MIMI_VERSION, MIMI_VERSION);
    }

    /**
     * Create necessary database tables.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function create_tables()
    {
        if (!function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        // Run the database table migrations.
        \VietDevelopers\MiMi\Databases\Migrations\InformationOfVisitorsMigration::migrate();
        \VietDevelopers\MiMi\Databases\Migrations\AutomatedAIProjectsMigration::migrate();
    }

    /**
     * Add wordpress options.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function add_options()
    {
        add_option(
            Keys::MIMI_STATUS_IMPORTED_DATA,
            0
        );

        add_option(
            Keys::MIMI_API_KEY,
            ""
        );

        add_option(
            Keys::MIMI_OPEN_AI_KEY,
            array(
                'key' => "",
                'model' => "",
            )
        );
    }
}
