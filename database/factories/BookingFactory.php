<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
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
        $company = Company::find(1) ?? Company::factory()->create();
        $user = User::find(1) ?? User::factory()->create();
        $company->users()->attach($user);

        return [
            'client_id' => Client::factory()->create(),
            'vehicle_id' => Vehicle::factory()->create([
                'company_id' => $company,
            ]),
            'company_id' => $company,
            'advisor_id' => $user,
        ];
    }
}
