<?php
namespace Database;

    use Database\Seeders\SalleSeeder;
    use Database\Seeders\UserSeeder;

    class Seed implements SeederInterface
    {
        public function run(): void
        {
            $seeders = [
                new UserSeeder(),
                new SalleSeeder(),
            ];

            foreach ($seeders as $seeder) {
                $seeder->run();
            }
        }
    }