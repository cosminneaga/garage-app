<?php

namespace Database\Factories;

use App\Models\Part;
use App\Models\Supplier;
use App\Models\VehicleMake;
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
        $supplier = Supplier::latest()->first() ?? Supplier::factory()->create();

        return [
            'name' => fake()->randomElement(['Oil Filter MANN', 'Oil Pan', 'Head Gasket', 'Piston', 'Piston Ring', 'Timing Kit']),
            'brand' => VehicleMake::factory()->create(),
            'supplier_id' => $supplier,
        ];
    }
}
