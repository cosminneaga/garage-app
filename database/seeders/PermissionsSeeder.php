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

        foreach (UserPermission::list() as $permission) {
            Permission::findOrCreate($permission);
        }

        /* ------------------------- PERMISSIONS ALLOCATION ------------------------- */
        $administrator->syncPermissions([
            ...UserPermission::list(
                excludeReferences: [
                    'country',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year',
                ]
            ),
            ...UserPermission::list(
                onlyReferences: [
                    'country',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year',
                ],
                onlyActions: ['show']
            )
        ]);

        $manager->syncPermissions([
            ...UserPermission::list(
                excludeReferences: [
                    'country',
                    'company',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year',
                ]
            ),
            ...UserPermission::list(
                onlyReferences: [
                    'country',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year',
                ],
                onlyActions: ['show']
            ),
            ...UserPermission::list(
                onlyReferences: ['company'],
                onlyActions: ['show', 'update']
            )
        ]);

        $user->syncPermissions([
            ...UserPermission::list(
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
            ...UserPermission::list(
                onlyReferences: [
                    'address',
                    'company',
                    'contact',
                    'country',
                    'user',
                    'vehicle_data',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_year',
                ],
                onlyActions: ['show']
            )
        ]);
    }
}
