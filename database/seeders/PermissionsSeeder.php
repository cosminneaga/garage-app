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
        $administrator = app(Role::class)->findOrCreate(UserRole::ADMINISTRATOR->value, 'web');
        $manager = app(Role::class)->findOrCreate(UserRole::MANAGER->value, 'web');
        $user = app(Role::class)->findOrCreate(UserRole::USER->value, 'web');

        // administrator
        foreach (UserPermission::list() as $permission) {
            $administrator->givePermissionTo($permission);
        }

        // manager
        $manager->givePermissionTo(UserPermission::name(UserPermission::USER, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));
        foreach (
            UserPermission::list(
                excludeReferences: ['company'],
            ) as $permission
        ) {
            $manager->givePermissionTo($permission);
        }

        // user
        foreach (
            UserPermission::list(
                excludeActions: ['restore', 'store', 'update', 'delete'],
            ) as $permission
        ) {
            $user->givePermissionTo($permission);
        }
    }
}
