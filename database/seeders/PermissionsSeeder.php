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

        // super admin
        // $userRoleAdmin->givePermissionTo('address_show');
        // $userRoleAdmin->givePermissionTo('address_store');
        // $userRoleAdmin->givePermissionTo('address_update');
        // $userRoleAdmin->givePermissionTo('address_delete');
        // $userRoleAdmin->givePermissionTo('address_restore');

        // $userRoleAdmin->givePermissionTo('client_show');
        // $userRoleAdmin->givePermissionTo('client_store');
        // $userRoleAdmin->givePermissionTo('client_update');
        // $userRoleAdmin->givePermissionTo('client_delete');
        // $userRoleAdmin->givePermissionTo('client_restore');

        // $userRoleAdmin->givePermissionTo('company_show');
        // $userRoleAdmin->givePermissionTo('company_store');
        // $userRoleAdmin->givePermissionTo('company_update');
        // $userRoleAdmin->givePermissionTo('company_delete');
        // $userRoleAdmin->givePermissionTo('company_restore');

        // $userRoleAdmin->givePermissionTo('country_show');
        // $userRoleAdmin->givePermissionTo('country_store');
        // $userRoleAdmin->givePermissionTo('country_update');
        // $userRoleAdmin->givePermissionTo('country_delete');
        // $userRoleAdmin->givePermissionTo('country_restore');

        // $userRoleAdmin->givePermissionTo('product_show');
        // $userRoleAdmin->givePermissionTo('product_store');
        // $userRoleAdmin->givePermissionTo('product_update');
        // $userRoleAdmin->givePermissionTo('product_delete');
        // $userRoleAdmin->givePermissionTo('product_restore');

        // $userRoleAdmin->givePermissionTo('repair_show');
        // $userRoleAdmin->givePermissionTo('repair_store');
        // $userRoleAdmin->givePermissionTo('repair_update');
        // $userRoleAdmin->givePermissionTo('repair_delete');
        // $userRoleAdmin->givePermissionTo('repair_restore');

        // $userRoleAdmin->givePermissionTo('repair-file_show');
        // $userRoleAdmin->givePermissionTo('repair-file_store');
        // $userRoleAdmin->givePermissionTo('repair-file_update');
        // $userRoleAdmin->givePermissionTo('repair-file_delete');
        // $userRoleAdmin->givePermissionTo('repair-file_restore');

        // $userRoleAdmin->givePermissionTo('repair-invoice_show');
        // $userRoleAdmin->givePermissionTo('repair-invoice_store');
        // $userRoleAdmin->givePermissionTo('repair-invoice_update');
        // $userRoleAdmin->givePermissionTo('repair-invoice_delete');
        // $userRoleAdmin->givePermissionTo('repair-invoice_restore');

        // $userRoleAdmin->givePermissionTo('repair-invoice-item_show');
        // $userRoleAdmin->givePermissionTo('repair-invoice-item_store');
        // $userRoleAdmin->givePermissionTo('repair-invoice-item_update');
        // $userRoleAdmin->givePermissionTo('repair-invoice-item_delete');
        // $userRoleAdmin->givePermissionTo('repair-invoice-item_restore');

        // $userRoleAdmin->givePermissionTo('user_show');
        // $userRoleAdmin->givePermissionTo('user_store');
        // $userRoleAdmin->givePermissionTo('user_update');
        // $userRoleAdmin->givePermissionTo('user_delete');
        // $userRoleAdmin->givePermissionTo('user_restore');

        // $userRoleAdmin->givePermissionTo('vehicle-data_show');
        // $userRoleAdmin->givePermissionTo('vehicle-data_store');
        // $userRoleAdmin->givePermissionTo('vehicle-data_update');
        // $userRoleAdmin->givePermissionTo('vehicle-data_delete');
        // $userRoleAdmin->givePermissionTo('vehicle-data_restore');

        // $userRoleAdmin->givePermissionTo('vehicle-make_show');
        // $userRoleAdmin->givePermissionTo('vehicle-make_store');
        // $userRoleAdmin->givePermissionTo('vehicle-make_update');
        // $userRoleAdmin->givePermissionTo('vehicle-make_delete');
        // $userRoleAdmin->givePermissionTo('vehicle-make_restore');

        // $userRoleAdmin->givePermissionTo('vehicle-model_show');
        // $userRoleAdmin->givePermissionTo('vehicle-model_store');
        // $userRoleAdmin->givePermissionTo('vehicle-model_update');
        // $userRoleAdmin->givePermissionTo('vehicle-model_delete');
        // $userRoleAdmin->givePermissionTo('vehicle-model_restore');

        // $userRoleAdmin->givePermissionTo('vehicle-year_show');
        // $userRoleAdmin->givePermissionTo('vehicle-year_store');
        // $userRoleAdmin->givePermissionTo('vehicle-year_update');
        // $userRoleAdmin->givePermissionTo('vehicle-year_delete');
        // $userRoleAdmin->givePermissionTo('vehicle-year_restore');
    }
}
