<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
        $latitude = fake()->latitude();
        $longitude = fake()->longitude();

        return [
            'number' => fake()->buildingNumber(),
            'street' => fake()->streetName(),
            'postcode' => fake()->postcode(),
            'coordinates' => DB::raw("ST_PointFromText('POINT($longitude $latitude)')"),
            'extra' => fake()->secondaryAddress(),
        ];
    }
}
