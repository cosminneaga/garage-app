<?php

namespace Database\Seeders;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        /*
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
        */

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        app(Role::class)->findOrCreate(UserRole::SUPER->value, 'web');
        $administrator = app(Role::class)->findOrCreate(UserRole::ADMINISTRATOR->value, 'web');
        $manager = app(Role::class)->findOrCreate(UserRole::MANAGER->value, 'web');
        $user = app(Role::class)->findOrCreate(UserRole::USER->value, 'web');

        $permissions = [
            UserRole::ADMINISTRATOR->value => UserPermission::list(),
            UserRole::MANAGER->value => UserPermission::list(excludeReferences: ['company']),
            UserRole::USER->value => UserPermission::list(excludeActions: ['restore', 'store', 'update', 'delete'])
        ];

        $insertPermissions = fn ($role) => collect($permissions[$role])
            ->map(function ($name) {
                $permission = DB::table('permissions')
                    ->where('name', $name)
                    ->lockForUpdate()
                    ->first();

                if ($permission) {
                    return DB::table('permissions')->find($permission->id)->id;
                }

                return DB::table('permissions')->insertGetId(['name' => $name, 'guard_name' => 'web']);
            })
            ->toArray();

        $roleWithPermissions = [
            $administrator->id => $insertPermissions(UserRole::ADMINISTRATOR->value),
            $manager->id => $insertPermissions(UserRole::MANAGER->value),
            $user->id => $insertPermissions(UserRole::USER->value)
        ];

        /* ------------------------- PRIVILEGED PERMISSIONS ------------------------- */
        $manager->givePermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));

        foreach ($roleWithPermissions as $roleId => $permissions) {
            DB::table('role_has_permissions')
                ->insert(collect($permissions)->map(fn ($permissionId) => [
                    'role_id' => $roleId,
                    'permission_id' => $permissionId
                ])->toArray());
        }
    }
}
