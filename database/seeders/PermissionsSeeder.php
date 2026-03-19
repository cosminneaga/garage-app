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

        Permission::create(['name' => 'users_show']);
        Permission::create(['name' => 'users_store']);
        Permission::create(['name' => 'users_update']);
        Permission::create(['name' => 'users_delete']);

        Permission::create(['name' => 'clients_show']);
        Permission::create(['name' => 'clients_store']);
        Permission::create(['name' => 'clients_update']);
        Permission::create(['name' => 'clients_delete']);

        $userRoleAdmin = Role::create(['name' => 'super']);
        $userRoleEditor = Role::create(['name' => 'editor']);
        $userRoleViewer = Role::create(['name' => 'viewer']);

        // super admin
        $userRoleAdmin->givePermissionTo('users_show');
        $userRoleAdmin->givePermissionTo('users_store');
        $userRoleAdmin->givePermissionTo('users_update');
        $userRoleAdmin->givePermissionTo('users_delete');
        $userRoleAdmin->givePermissionTo('clients_show');
        $userRoleAdmin->givePermissionTo('clients_store');
        $userRoleAdmin->givePermissionTo('clients_update');
        $userRoleAdmin->givePermissionTo('clients_delete');

        // editor
        $userRoleEditor->givePermissionTo('users_show');
        $userRoleEditor->givePermissionTo('users_store');
        $userRoleEditor->givePermissionTo('users_update');
        $userRoleEditor->givePermissionTo('clients_show');
        $userRoleEditor->givePermissionTo('clients_store');
        $userRoleEditor->givePermissionTo('clients_update');

        // viewer
        $userRoleViewer->givePermissionTo('clients_show');
    }
}
