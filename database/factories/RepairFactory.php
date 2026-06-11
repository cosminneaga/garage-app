<?php

namespace Database\Factories;

use App\Enums\FuelType;
use App\Enums\RepairStatus;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
use App\Models\Repair;
use App\Models\VehicleData;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Repair>
 */
class RepairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'registration' => strtoupper(fake()->bothify('??##???')),
            'vin' => fake()->ean13(),
            'odometer' => fake()->randomNumber(5, false),
            'fuel' => fake()->randomElement(FuelType::class),
            'status' => fake()->randomElement(RepairStatus::class),
            'complaint_description' => fake()->randomHTML(),
            'initial_inspection' => fake()->randomHTML(),
            'diagnosis_notes' => fake()->randomHTML(),
            'work_order' => fake()->randomHTML(),
            'parts_required' => fake()->randomHTML(),
            'execution_data' => fake()->randomHTML(),
            'labour_tracking_data' => fake()->randomHTML(),
            'quality_check_testing' => fake()->randomHTML(),
            'service_record' => fake()->randomHTML(),

            'booking_id' => Booking::factory(),
            'vehicle_data_id' => VehicleData::factory(),
            'company_id' => Company::factory(),
            'client_id' => Client::factory(),
        ];
    }
}
