<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DevUsersRolesAndCountries::class,
            VehicleSeeder::class,
        ]);
    }
}
