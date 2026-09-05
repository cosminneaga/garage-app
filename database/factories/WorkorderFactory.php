<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Workorder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Workorder>
 */
class WorkorderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $booking = Booking::latest()->first() ?? Booking::factory()->create();
        $user = User::latest()->first() ?? User::factory()->create();

        return [
            'title' => fake()->text(40),
            'booking_id' => $booking,
            'technician_id' => $user,
        ];
    }
}
