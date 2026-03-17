<?php

namespace Database\Seeders;

use App\Models\User;
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

        Permission::create(['name' => 'clients_show']);
        Permission::create(['name' => 'clients_store']);
        Permission::create(['name' => 'clients_update']);
        Permission::create(['name' => 'clients_delete']);

        $userRoleAdmin = Role::create(['name' => 'super']);
        $userRoleEditor = Role::create(['name' => 'editor']);
        $userRoleViewer = Role::create(['name' => 'viewer']);

        $userRoleAdmin->givePermissionTo('clients_show');
        $userRoleAdmin->givePermissionTo('clients_store');
        $userRoleAdmin->givePermissionTo('clients_update');
        $userRoleAdmin->givePermissionTo('clients_delete');

        $userRoleEditor->givePermissionTo('clients_show');
        $userRoleEditor->givePermissionTo('clients_store');
        $userRoleEditor->givePermissionTo('clients_update');

        $userRoleViewer->givePermissionTo('clients_show');

        $adminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@garage.com',
            'active' => true,
        ]);
        $adminUser->assignRole($userRoleAdmin);

        $editorUser = User::factory()->create([
            'name' => 'Editor Admin',
            'email' => 'editor@garage.com',
            'active' => true,
        ]);
        $editorUser->assignRole($userRoleEditor);

        $viewerUser = User::factory()->create([
            'name' => 'Viewer Admin',
            'email' => 'viewer@garage.com',
            'active' => true,
        ]);
        $viewerUser->assignRole($userRoleViewer);
    }
}
