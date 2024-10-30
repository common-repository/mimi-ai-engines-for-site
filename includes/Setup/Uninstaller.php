<?php

namespace VietDevelopers\MiMi\Setup;

use VietDevelopers\MiMi\Common\Keys;

/**
 * Class Uninstaller.
 *
 * Uninstaller necessary database tables and options for the plugin.
 */
class Uninstaller
{
    /**
     * Run the uninstaller
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function run(): void
    {
        // Remove the installed version.
        $this->remove_version();

        // Remove the tables.
        $this->remove_tables();

        // Remove the options.
        $this->remove_options();
    }

    public function remove_version(): void
    {
        delete_option(Keys::MIMI_INSTALLED);
        delete_option(Keys::MIMI_VERSION);
    }

    public function remove_tables(): void
    {
        // Drop the database tables.
        \VietDevelopers\MiMi\Databases\Migrations\InformationOfVisitorsMigration::drop();
        \VietDevelopers\MiMi\Databases\Migrations\AutomatedAIProjectsMigration::drop();
    }

    public function remove_options()
    {
        delete_option(Keys::MIMI_STATUS_IMPORTED_DATA);
        delete_option(Keys::MIMI_API_KEY);
        delete_option(Keys::MIMI_OPEN_AI_KEY);
    }
}
