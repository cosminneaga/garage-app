<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call(PermissionsSeeder::class);
        /*
        // ADD address WITH coordinates
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
        */

        // ATTACHING users TO team
        $admin = User::factory()->create([
            'name' => 'ADMIN',
        ]);
        $admin->assignRole(UserRole::USER_EDITOR);

        $users = User::factory()->createMany([
            ['name' => 'User one'],
            ['name' => 'User two'],
            ['name' => 'User three'],
        ]);

        $admin->team()->attach($users);

        foreach ($admin->team()->get() as $member) {
            dump($member->name);
        }
    }
}
