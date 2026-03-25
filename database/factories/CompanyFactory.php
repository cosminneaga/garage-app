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
            'registration_no' => fake()->numberBetween(10000000, 99999999),
            'tax_value' => fake()->numberBetween(0, 45),
            'invoice_prefix' => fake()->word(),
        ];
    }
}
