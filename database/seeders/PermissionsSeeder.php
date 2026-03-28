<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'address_show']);
        Permission::create(['name' => 'address_store']);
        Permission::create(['name' => 'address_update']);
        Permission::create(['name' => 'address_delete']);
        Permission::create(['name' => 'address_restore']);

        Permission::create(['name' => 'client_show']);
        Permission::create(['name' => 'client_store']);
        Permission::create(['name' => 'client_update']);
        Permission::create(['name' => 'client_delete']);
        Permission::create(['name' => 'client_restore']);

        Permission::create(['name' => 'company_show']);
        Permission::create(['name' => 'company_store']);
        Permission::create(['name' => 'company_update']);
        Permission::create(['name' => 'company_delete']);
        Permission::create(['name' => 'company_restore']);

        Permission::create(['name' => 'country_show']);
        Permission::create(['name' => 'country_store']);
        Permission::create(['name' => 'country_update']);
        Permission::create(['name' => 'country_delete']);
        Permission::create(['name' => 'country_restore']);

        Permission::create(['name' => 'product_show']);
        Permission::create(['name' => 'product_store']);
        Permission::create(['name' => 'product_update']);
        Permission::create(['name' => 'product_delete']);
        Permission::create(['name' => 'product_restore']);

        Permission::create(['name' => 'repair_show']);
        Permission::create(['name' => 'repair_store']);
        Permission::create(['name' => 'repair_update']);
        Permission::create(['name' => 'repair_delete']);
        Permission::create(['name' => 'repair_restore']);

        Permission::create(['name' => 'repair-file_show']);
        Permission::create(['name' => 'repair-file_store']);
        Permission::create(['name' => 'repair-file_update']);
        Permission::create(['name' => 'repair-file_delete']);
        Permission::create(['name' => 'repair-file_restore']);

        Permission::create(['name' => 'repair-invoice_show']);
        Permission::create(['name' => 'repair-invoice_store']);
        Permission::create(['name' => 'repair-invoice_update']);
        Permission::create(['name' => 'repair-invoice_delete']);
        Permission::create(['name' => 'repair-invoice_restore']);

        Permission::create(['name' => 'repair-invoice-item_show']);
        Permission::create(['name' => 'repair-invoice-item_store']);
        Permission::create(['name' => 'repair-invoice-item_update']);
        Permission::create(['name' => 'repair-invoice-item_delete']);
        Permission::create(['name' => 'repair-invoice-item_restore']);

        Permission::create(['name' => 'user_show']);
        Permission::create(['name' => 'user_store']);
        Permission::create(['name' => 'user_update']);
        Permission::create(['name' => 'user_delete']);
        Permission::create(['name' => 'user_restore']);

        Permission::create(['name' => 'vehicle-data_show']);
        Permission::create(['name' => 'vehicle-data_store']);
        Permission::create(['name' => 'vehicle-data_update']);
        Permission::create(['name' => 'vehicle-data_delete']);
        Permission::create(['name' => 'vehicle-data_restore']);

        Permission::create(['name' => 'vehicle-make_show']);
        Permission::create(['name' => 'vehicle-make_store']);
        Permission::create(['name' => 'vehicle-make_update']);
        Permission::create(['name' => 'vehicle-make_delete']);
        Permission::create(['name' => 'vehicle-make_restore']);

        Permission::create(['name' => 'vehicle-model_show']);
        Permission::create(['name' => 'vehicle-model_store']);
        Permission::create(['name' => 'vehicle-model_update']);
        Permission::create(['name' => 'vehicle-model_delete']);
        Permission::create(['name' => 'vehicle-model_restore']);

        Permission::create(['name' => 'vehicle-year_show']);
        Permission::create(['name' => 'vehicle-year_store']);
        Permission::create(['name' => 'vehicle-year_update']);
        Permission::create(['name' => 'vehicle-year_delete']);
        Permission::create(['name' => 'vehicle-year_restore']);

        $userRoleAdmin = Role::create(['name' => 'super']);
    }
}
