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
            UserRole::ADMINISTRATOR->value => UserPermission::list(
                excludeReferences: [
                    'country',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year'
                ]
            ),
            UserRole::MANAGER->value => UserPermission::list(
                excludeReferences: [
                    'country',
                    'company',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year',
                ]
            ),
            UserRole::USER->value => UserPermission::list(
                excludeReferences: [
                    'address',
                    'contact',
                    'country',
                    'company',
                    'user',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year',
                ]
            ),
        ];

        foreach (UserPermission::list() as $permission) {
            Permission::findOrCreate($permission);
        }

        $administrator->syncPermissions($permissions[UserRole::ADMINISTRATOR->value]);
        $manager->syncPermissions($permissions[UserRole::MANAGER->value]);
        $user->syncPermissions($permissions[UserRole::USER->value]);

        /* ------------------------- GRANULATED PERMISSIONS ------------------------- */
        $administrator->givePermissionTo(UserPermission::name(UserPermission::COUNTRY, 'show'));
        $administrator->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_DATA, 'show'));
        $administrator->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_MAKE, 'show'));
        $administrator->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_MODEL, 'show'));
        $administrator->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_YEAR, 'show'));

        $manager->givePermissionTo(UserPermission::name(UserPermission::COUNTRY, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_DATA, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_MAKE, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_MODEL, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_YEAR, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));
        $manager->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'update'));

        $user->givePermissionTo(UserPermission::name(UserPermission::ADDRESS, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::CONTACT, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::COUNTRY, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::USER, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_DATA, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_MAKE, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_MODEL, 'show'));
        $user->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_YEAR, 'show'));
    }
}
