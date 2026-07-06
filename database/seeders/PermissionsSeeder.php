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
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Role::findOrCreate(UserRole::SUPER->value);
        $administrator = Role::findOrCreate(UserRole::ADMINISTRATOR->value);
        $manager = Role::findOrCreate(UserRole::MANAGER->value);
        $user = Role::findOrCreate(UserRole::USER->value);

        $permissions = [
            UserRole::ADMINISTRATOR->value => UserPermission::list(),
            UserRole::MANAGER->value => UserPermission::list(excludeReferences: ['company']),
            UserRole::USER->value => UserPermission::list(excludeReferences: ['user', 'permission'], excludeActions: ['restore', 'store', 'update', 'delete']),
        ];

        foreach (UserPermission::list() as $permission) {
            Permission::findOrCreate($permission);
        }

        $administrator->syncPermissions($permissions[UserRole::ADMINISTRATOR->value]);
        $manager->syncPermissions($permissions[UserRole::MANAGER->value]);
        $user->syncPermissions($permissions[UserRole::USER->value]);

        /* ------------------------- PRIVILEGED PERMISSIONS ------------------------- */
        $manager->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'update'));
    }
}
