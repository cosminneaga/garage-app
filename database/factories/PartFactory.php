<?php

namespace Database\Factories;

use App\Models\CarMake;
use App\Models\Part;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Part>
 */
class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Oil Filter MANN', 'Oil Pan', 'Head Gasket', 'Piston', 'Piston Ring', 'Timing Kit']),
            'brand' => CarMake::factory()->create(),
            'item_price' => fake()->randomFloat(2, 0, 100000),
            'commercial_markup' => fake()->randomFloat(2, 0, 100),
            'manufacturer' => fake()->randomElement(['MANN', 'Brembo', 'Bosch', 'VM']),
            'part_number' => fake()->ean8(),
            'serial_number' => fake()->ean13(),
            'code' => fake()->bothify('#####-????????-#######'),
            'notes' => fake()->paragraph(2),
        ];
    }
}
