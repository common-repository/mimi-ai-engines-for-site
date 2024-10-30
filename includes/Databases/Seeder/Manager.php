<?php

namespace VietDevelopers\MiMi\Databases\Seeder;

/**
 * Database Seeder class.
 *
 * It'll seed all of the seeders.
 */
class Manager
{

    /**
     * Run the database seeders.
     *
     * @since 1.0.0
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $seeder_classes = [
            \VietDevelopers\MiMi\Databases\Seeder\VisitorInformationSeeder::class,
        ];

        foreach ($seeder_classes as $seeder_class) {
            $seeder = new $seeder_class();
            $seeder->run();
        }
    }
}
