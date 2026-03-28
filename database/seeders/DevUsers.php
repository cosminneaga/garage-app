<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // permissions
        $this->call(PermissionsSeeder::class);

        // countries
        $this->call(CountriesSeeder::class);
        $country = Country::first();

        // contact & address
        $contact = Contact::factory(10)->create();
        $address = Address::factory(10)->create([
            'country_id' => $country,
        ]);

        // admin
        $adminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $adminUser->addresses()->attach([$address[0]->id, $address[1]->id]);
        $adminUser->contacts()->attach([$contact[0]->id, $contact[1]->id]);
        $adminUser->assignRole(UserRole::ADMIN_SUPER->value);
        $company = Company::factory()->create();
        $company->addresses()->attach($address[4]->id);
        $company->contacts()->attach($contact[4]->id);
        $adminUser->companies()->attach($company->id);
        $products = Product::factory(10)->create([
            'company_id' => $company,
        ]);

        // user admin
        $userAdmin = User::factory()->create([
            'name' => 'User Manager',
            'email' => 'manager@garage.com',
            'password' => 'password',
            'active' => true,
        ]);
        $userAdmin->addresses()->attach($address[2]->id);
        $userAdmin->contacts()->attach($contact[2]->id);
        $userAdmin->assignRole(UserRole::USER_ADMIN->value);
        $company = Company::factory()->create();
        $company->addresses()->attach($address[5]->id);
        $company->contacts()->attach($contact[5]->id);
        $userAdmin->companies()->attach($company->id);
        $products = Product::factory(10)->create([
            'company_id' => $company,
        ]);
        $company = Company::factory()->create();
        $company->addresses()->attach($address[5]->id);
        $company->contacts()->attach($contact[5]->id);
        $userAdmin->companies()->attach($company->id);
        $products = Product::factory(10)->create([
            'company_id' => $company,
        ]);
    }
}
