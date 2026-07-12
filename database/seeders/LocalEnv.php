<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class LocalEnv extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. seed role-permissions
        $this->call(PermissionsSeeder::class);

        // 2. seed countries
        $this->call(CountriesSeeder::class);
        $country = Country::first(['*']);

        // 3. seed super admin & rest of test users
        $users = User::factory()->createMany([
            [
                'name' => 'Super Admin',
                'email' => 'super@garage.com',
                'password' => 'password',
                'active' => true,
            ],
            [
                'name' => 'Administrator User',
                'email' => 'administrator@garage.com',
                'password' => 'password',
                'active' => true,
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@garage.com',
                'password' => 'password',
                'active' => true,
            ],
            [
                'name' => 'User',
                'email' => 'user@garage.com',
                'password' => 'password',
                'active' => true,
            ],
        ]);

        // 4. assign roles & create team
        $users[0]->assignRole(UserRole::SUPER);
        $users[1]->assignRole(UserRole::ADMINISTRATOR);
        $users[2]->assignRole(UserRole::MANAGER);
        $users[3]->assignRole(UserRole::USER);
        $users[1]->managers()->attach($users[2]);
        $users[2]->users()->attach($users[3]);

        // 5. creating & attaching addresses & contacts
        $users[0]->addresses()->attach(Address::factory()->create(['country_id' => $country->id]));
        $users[0]->contacts()->attach(Contact::factory()->create());
        $users[1]->addresses()->attach(Address::factory()->create(['country_id' => $country->id]));
        $users[1]->contacts()->attach(Contact::factory()->create());
        $users[2]->addresses()->attach(Address::factory()->create(['country_id' => $country->id]));
        $users[2]->contacts()->attach(Contact::factory()->create());
        $users[3]->addresses()->attach(Address::factory()->create(['country_id' => $country->id]));
        $users[3]->contacts()->attach(Contact::factory()->create());

        // 6. creating & attaching companies & suppliers
        $companies = Company::factory(10)->create();
        $companies->each(function ($company) use ($country, $users) {
            $company->addresses()->attach(Address::factory()->create(['country_id' => $country->id]));
            $company->contacts()->attach(Contact::factory()->create());

            $supplier = Supplier::factory()->create();
            $supplier->addresses()->attach(Address::factory()->create(['country_id' => $country->id]));
            $supplier->contacts()->attach(Contact::factory()->create());
            $company->suppliers()->attach($supplier);

            $users[1]->companies()->attach($company);
        });
        $companies[0]->users()->attach([$users[2], $users[3]]);


        // 7. create clients with address & contact & attach to the first company
        $clients = Client::factory(10)->create();
        $clients->each(function ($client) use ($country, $companies) {
            $client->addresses()->attach(Address::factory()->create(['country_id' => $country->id]));
            $client->contacts()->attach(Contact::factory()->create());
            $client->companies()->attach($companies[0]);
        });
    }
}
