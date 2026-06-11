<?php

namespace Database\Factories;

use App\Models\Country;
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
            'street' => fake()->streetName(),
            'postcode' => fake()->postcode(),
            'coordinates' => [
                'latitude' => floatval(fake()->latitude()),
                'longitude' => floatval(fake()->longitude()),
            ],
            'extra' => fake()->secondaryAddress(),
            'country_id' => Country::factory(),
        ];
    }
}
