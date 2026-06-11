<?php

namespace Database\Factories;

use App\Enums\SupplierType;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
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
            'tax_id' => fake()->numberBetween(10000000, 99999999),
            'registration_number' => fake()->numberBetween(10000000, 99999999),
            'code' => 'NIMACODE43',
            'type' => fake()->randomElement(SupplierType::class),
        ];
    }
}
