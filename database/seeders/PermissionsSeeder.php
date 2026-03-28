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

        $permissions = UserPermission::values();

        foreach ($permissions as $permission) {
            Permission::make(['name' => $permission])->saveOrFail();
        }

        $adminSuper = app(Role::class)->findOrCreate(UserRole::ADMIN_SUPER->value, 'web');
        $userAdmin = app(Role::class)->findOrCreate(UserRole::USER_ADMIN->value, 'web');
        $userEditor = app(Role::class)->findOrCreate(UserRole::USER_EDITOR->value, 'web');
        $userViewer = app(Role::class)->findOrCreate(UserRole::USER_VIEWER->value, 'web');

        // user admin
        $userAdmin->givePermissionTo(UserPermission::PRODUCT_SHOW->value);
        $userAdmin->givePermissionTo(UserPermission::COMPANY_SHOW->value);
    }
}
