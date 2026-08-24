<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Enums\Priority;
use App\Enums\ServiceType;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            'number' => fake()->numerify('BK-#########'),
            'status' => fake()->randomElement(BookingStatus::values()),
            'service_type' => fake()->randomElement(ServiceType::values()),
            'priority' => fake()->randomElement(Priority::values()),
            'appointment_start' => Carbon::now()->addDays(fake()->randomElement([2, 10, 5])),
            'notes' => fake()->text(),
            'client_notes' => fake()->text(),

            'client_id' => Client::factory()->create(),
            'vehicle_id' => Vehicle::factory()->create(),
            'company_id' => Company::factory()->create(),
            'advisor_id' => User::factory()->create(),
        ];
    }
}
