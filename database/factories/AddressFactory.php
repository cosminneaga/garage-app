<?php

namespace Database\Factories;

use App\Dto\Coordinates;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AddressFactory>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->buildingNumber(),
            'name' => fake()->streetName(),
            'postcode' => fake()->postcode(),
            'coordinates' => new Coordinates(fake()->latitude(), fake()->longitude()),
            'building' => fake()->buildingNumber(),
            'floor' => fake()->buildingNumber(),
            'unit' => fake()->buildingNumber(),
            'country_id' => 1,
            'state_id' => 1,
            'city_id' => 1,
        ];
    }
}
