<?php

namespace Database\Factories;

use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarModel>
 */
class CarModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['A3', 'Corolla', 'Tiguan', 'RAV4']),
            'class' => fake()->randomElement(['Small/Mini', 'Medium', 'Executive', 'MPV']),
            'make_id' => CarMake::factory(),
        ];
    }
}
