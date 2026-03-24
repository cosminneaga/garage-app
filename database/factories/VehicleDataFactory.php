<?php

namespace Database\Factories;

use App\Models\VehicleData;
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
            'name' => fake()->text($maxNbChars = 40),
            'cylinders' => fake()->numberBetween($min = 3, $max = 18),
            'displacement' => fake()->randomFloat($nbMaxDecimals = 1, $min = 1.0, $max = 20.0),
            'drive' => fake()->text($maxNbChars = 10),
            'transmission' => fake()->text($maxNbChars = 10),
        ];
    }
}
