<?php

namespace Database\Factories;

use App\Enums\FuelType;
use App\Enums\VehicleStatus;
use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            'vin' => fake()->unique()->numerify('BH####YO######'),
            'registration' => fake()->numerify('BH##LOH'),
            'fuel' => fake()->randomElement(FuelType::values()),
            'status' => fake()->randomElement(VehicleStatus::values()),

            'company_id' => Company::factory()->create(),
        ];
    }
}
