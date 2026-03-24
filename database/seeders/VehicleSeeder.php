<?php

namespace Database\Seeders;

use App\Models\VehicleData;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        include './json/makes.php';
        include './json/models.php';
        include './json/years.php';
        include './json/vehicles.php';

        VehicleMake::factory()->createMany($makes);
        VehicleModel::factory()->createMany($models);
        VehicleYear::factory()->createMany($years);
        VehicleData::factory()->createMany($vehicles);
    }
}
