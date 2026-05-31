<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
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
            'street' => 'SunFlower Street',
            'coordinates' => [
                'latitude' => 4.895168,
                'longitude' => 52.370216,
            ],
            'country_id' => Country::factory()->create([
                'name' => 'Argentina',
                'code' => 'AG',
            ]),
        ]);

        // dump($address);
        dump($address->coordinates);
        */

        // ATTACHING users TO team
        $admin = User::where('email', 'manager@garage.com')->first();

        // COMPANIES
        // $companies = Company::factory(50)->create();
        // collect($companies)->map(function ($company) {
        //     $company->contacts()->attach(Contact::factory()->create());
        //     $company->addresses()->attach(Address::factory()->create([
        //         'country_id' => 1,
        //     ]));
        // });

        // $admin->companies()->attach($companies);

        // USERS
        $users = User::factory(50)->create();

        foreach ($users as $user) {

            $contact = Contact::factory()->create();
            $address = Address::factory()->create([
                'country_id' => 1,
            ]);

            $user->contacts()->attach($contact);
            $user->addresses()->attach($address);
        }

        $admin->team()->attach($users);

        // USERS DELETE
        // $users = $admin->team()->get();
        // foreach ($users as $user) {
        //     $user->forceDelete();
        // }
    }
}
