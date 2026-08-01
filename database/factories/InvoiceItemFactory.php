<?php

namespace Database\Factories;

use App\Enums\JobName;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_name' => fake()->randomElement(JobName::values()),
            'sku' => fake()->ean13(),
            'quantity' => fake()->numberBetween(1, 5),
            'item_price' => fake()->randomFloat(2, 1, 999),
            'labour_price' => fake()->randomFloat(2, 1, 999),
            'invoice_id' => Invoice::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
