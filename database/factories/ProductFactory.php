<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Break Pads',
                'Break Disks',
                'Fuel Filter',
                'Oil Filter',
                'Air Filter',
                'Cabin Filter',
                'Windshield',
                'Left door',
                'Right door',
                'Hood',
                'Piston',
                'Crankshaft',
                'Camshaft',
                'Piston Rings',
            ]),
            'code' => fake()->randomElement([
                'BP',
                'BD',
                'OF',
                'AF',
                'FF',
                'CF',
                'HD',
            ]),
        ];
    }
}
