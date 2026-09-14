<?php

namespace Database\Seeders;

use App\Models\CarData;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        include './json/vehicles/makes.php';
        include './json/vehicles/models.php';
        include './json/vehicles/data.php';

        CarMake::factory()->createMany($makes);
        CarModel::factory()->createMany($models);
        CarData::factory()->createMany($data);
    }
}
