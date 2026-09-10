<?php
namespace Database;

    use Database\Seeders\SalleSeeder;

    class Seed implements SeederInterface
    {
        public function run(): void
        {
            $seeders = [
                new SalleSeeder(),
            ];

            foreach ($seeders as $seeder) {
                $seeder->run();
            }
        }
    }