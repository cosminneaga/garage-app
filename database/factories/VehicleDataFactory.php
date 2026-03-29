<?php

namespace Database\Factories;

use App\Models\VehicleData;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VehicleData>
 */
class VehicleDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                '4-Speed Automatic, Front-Wheel Drive, 4 cyl, 2.2L',
                '5-Speed Manual, Front-Wheel Drive, 4 cyl, 2.2L',
                '4-Speed Automatic, Front-Wheel Drive, 4 cyl, 2.3L',
            ]),
            'cylinders' => fake()->numberBetween($min = 3, $max = 18),
            'displacement' => fake()->randomFloat($nbMaxDecimals = 1, $min = 1.0, $max = 20.0),
            'drive' => fake()->randomElement([
                'All-Wheel (AWD)',
                'Four-Wheel (4WD)',
                'Front-Wheel (FWD)'
                ]),
            'transmission' => fake()->randomElement([
                'Manual',
                'Automatic (AT)',
                'Continuously Variable (CVT)',
                'Dual-Clutch (DCT)'
            ]),
            'vehicle_make_id' => VehicleMake::factory(),
            'vehicle_model_id' => VehicleModel::factory(),
            'vehicle_year_id' => VehicleYear::factory(),
        ];
    }
}
