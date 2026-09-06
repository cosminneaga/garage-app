<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Client;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory()->create(),
            'vehicle_id' => Vehicle::factory()->create(),
            'company_id' => null,
            'advisor_id' => User::factory()->create(),
        ];
    }
}
