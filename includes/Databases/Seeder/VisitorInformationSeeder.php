<?php

namespace VietDevelopers\MiMi\Databases\Seeder;

use VietDevelopers\MiMi\Abstracts\DBSeeder;
use VietDevelopers\MiMi\Common\Keys;

/**
 * VisitorInformation Seeder class.
 *
 * Seed some fresh emails for initial startup.
 */
class VisitorInformationSeeder extends DBSeeder
{

    /**
     * Run VisitorInformations seeder.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function run()
    {
        global $wpdb;

        // Check if there is already a seeder runs for this plugin.
        $already_seeded = (bool) get_option(Keys::VISITOR_INFORMATION_SEEDER_RAN, false);
        if ($already_seeded) {
            return;
        }

        // Generate some visitor_informations.
        $visitor_informations = [
            [
                'visitor_id'        => '1231231',
                'fullname'          => 'Đức Chiến',
                'email'             => 'phamchienvn91@gmail.com',
                'phone_number'      => '0859281121',
                'note'              => 'test',
                'joined_time'       => current_datetime()->format('Y-m-d H:i:s'),
                'conversation_id'   => '1231231',
            ],
        ];

        // Create each of the visitor_informations.
        foreach ($visitor_informations as $visitor_information) {
            $wpdb->insert(
                $wpdb->prefix . 'mimi_visitor_informations',
                $visitor_information
            );
        }

        // Update that seeder already runs.
        update_option(Keys::VISITOR_INFORMATION_SEEDER_RAN, true);
    }
}
