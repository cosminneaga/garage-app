<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Country;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $address = Address::factory()->create([
            'number' => 777,
            'street' => 'Cosmin Street',
            'coordinates' => [
                'latitude' => 4.895168,
                'longitude' => 52.370216,
            ],
            'country_id' => Country::factory()->create([
                'name' => 'Cosmin',
                'code' => 'CCS',
            ]),
        ]);

        // dump($address);
        dump($address->coordinates);
    }
}
