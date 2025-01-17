<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * To run the seeder to enter database:
     * php artisan db:seed
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            DisposalStatusesSeeder::class, // Include your existing seeder
        ]);
    }
}
