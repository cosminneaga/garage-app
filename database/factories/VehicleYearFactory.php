<?php

namespace Database\Factories;

use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VehicleYear>
 */
class VehicleYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => fake()->year(),
            'vehicle_model_id' => VehicleModel::factory(),
        ];
    }
}
