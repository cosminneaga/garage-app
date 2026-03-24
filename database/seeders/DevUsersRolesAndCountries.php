<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevUsersRolesAndCountries extends Seeder
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
        $contact = Contact::factory(5)->create();
        $address = Address::factory(5)->create([
            'country_id' => $country,
        ]);

        // admin
        $adminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@garage.com',
            'active' => true,
        ]);
        $adminUser->addresses()->attach([$address[0]->id, $address[1]->id]);
        $adminUser->contacts()->attach([$contact[0]->id, $contact[1]->id]);

        // editor
        $editorUser = User::factory()->create([
            'name' => 'Editor Admin',
            'email' => 'editor@garage.com',
            'active' => true,
        ]);
        $editorUser->addresses()->attach($address[2]->id);
        $editorUser->contacts()->attach($contact[2]->id);

        // viewer
        $viewerUser = User::factory()->create([
            'name' => 'Viewer Admin',
            'email' => 'viewer@garage.com',
            'active' => true,
        ]);
        $viewerUser->addresses()->attach($address[3]->id);
        $viewerUser->contacts()->attach($contact[3]->id);

        // roles assignation
        $adminUser->assignRole('super');
        $editorUser->assignRole('editor');
        $viewerUser->assignRole('viewer');

        // company
        $company = Company::factory()->create();
        $company->addresses()->attach($address[4]->id);
        $company->contacts()->attach($contact[4]->id);
        $adminUser->companies()->attach($company->id);
        $editorUser->companies()->attach($company->id);
        $viewerUser->companies()->attach($company->id);

        // products
        $products = Product::factory(10)->create([
            'company_id' => $company,
        ]);
    }
}
