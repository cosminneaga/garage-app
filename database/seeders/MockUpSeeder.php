<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class MockUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(PermissionsSeeder::class);

        $adminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@garage.com',
            'active' => true,
        ]);
        $adminUser->assignRole('super');

        $editorUser = User::factory()->create([
            'name' => 'Editor Admin',
            'email' => 'editor@garage.com',
            'active' => true,
        ]);
        $editorUser->assignRole('editor');

        $viewerUser = User::factory()->create([
            'name' => 'Viewer Admin',
            'email' => 'viewer@garage.com',
            'active' => true,
        ]);
        $viewerUser->assignRole('viewer');

        // country
        $country = Country::factory()->create();

        // company
        $company = Company::factory()->create([
            'country_id' => $country,
        ]);
        $adminUser->companies()->attach($company->id);

        // products
        $products = Product::factory(10)->create([
            'company_id' => $company,
        ]);
    }
}
