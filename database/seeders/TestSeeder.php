<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::find(1);
        $vehicle = Vehicle::find(1);
        $client = Client::find(1);

        $invoice = Invoice::factory()->create([
            'company_id' => $company->id,
            'vehicle_id' => $vehicle->id,
            'client_id' => $client->id,
        ]);
    }
}
