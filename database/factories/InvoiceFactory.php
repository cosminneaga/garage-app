<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\Repair;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => fake()->randomNumber(5, true),
            'work_time' => fake()->randomFloat(1, 1, 48),
            'hourly_charge' => fake()->randomFloat(2, 5, 85),
            'status' => fake()->randomElement(InvoiceStatus::class),
            'discount_applied' => fake()->randomFloat(2, 5, 85),
            'paid_amount' => 0.00,
            'description' => fake()->text(60),
            'repair_id' => Repair::factory(),
        ];
    }
}
