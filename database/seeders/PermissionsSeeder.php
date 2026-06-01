<?php

namespace Database\Seeders;

use App\Enums\UserPermission;
use App\Enums\UserRole;
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

        foreach (UserPermission::list() as $permission) {
            Permission::create(['name' => $permission]);
        }

        app(Role::class)->findOrCreate(UserRole::SUPER->value, 'web');
        $userAdmin = app(Role::class)->findOrCreate(UserRole::USER_ADMIN->value, 'web');
        $userEditor = app(Role::class)->findOrCreate(UserRole::USER_EDITOR->value, 'web');
        $userViewer = app(Role::class)->findOrCreate(UserRole::USER_VIEWER->value, 'web');

        // user admin
        foreach (UserPermission::list() as $permission) {
            $userAdmin->givePermissionTo($permission);
        }

        // user editor
        $userEditor->givePermissionTo(UserPermission::name(UserPermission::USER, 'show'));
        $userEditor->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));
        $userEditor->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'update'));
        foreach (
            UserPermission::list(
                excludeReferences: ['user', 'company'],
                excludeActions: ['restore', 'delete'],
            ) as $permission
        ) {
            $userEditor->givePermissionTo($permission);
        }

        // user viewer
        foreach (
            UserPermission::list(
                excludeActions: ['restore', 'store', 'update', 'delete'],
            ) as $permission
        ) {
            $userViewer->givePermissionTo($permission);
        }
    }
}
