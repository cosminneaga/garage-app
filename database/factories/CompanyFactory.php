<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'email' => fake()->email(),
            'street' => fake()->address(),
            'city' => fake()->city(),
            'postcode' => fake()->postcode(),
            'registration_no' => fake()->numberBetween(10000000, 99999999),
            'mobile' => fake()->phoneNumber(),
            'landline' => fake()->phoneNumber(),
        ];
    }
}
