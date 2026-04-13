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
            'tax_id' => fake()->numberBetween(10000000, 99999999),
            'registration_number' => fake()->numberBetween(10000000, 99999999),
            'tax_value' => fake()->numberBetween(0.0, 45.0),
            'invoice_prefix' => fake()->ean8(),
            'image_path' => fake()->randomElement([
                'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8bG9nb3xlbnwwfHwwfHx8MA%3D%3D',
                'https://images.unsplash.com/photo-1620288627223-53302f4e8c74?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bG9nb3xlbnwwfHwwfHx8MA%3D%3D',
                'https://images.unsplash.com/photo-1545231027-637d2f6210f8?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bG9nb3xlbnwwfHwwfHx8MA%3D%3D',
                'https://images.unsplash.com/photo-1563694983011-6f4d90358083?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8bG9nb3xlbnwwfHwwfHx8MA%3D%3D',
                'https://images.unsplash.com/photo-1612810806563-4cb8265db55f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGxvZ298ZW58MHx8MHx8fDA%3D'
            ]),
        ];
    }
}
