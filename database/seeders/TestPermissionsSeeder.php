<?php

namespace Database\Seeders;

use App\Enums\Environment;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\PermissionRegistrar;

class TestPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        App::make(PermissionRegistrar::class)->forgetCachedPermissions();
        Environment::insertRoles();

        $administratorPermissions = Environment::insertPermissionsByEnvironment(Environment::TEST, UserRole::ADMINISTRATOR);
        $managerPermissions = Environment::insertPermissionsByEnvironment(Environment::TEST, UserRole::MANAGER);
        $userPermissions = Environment::insertPermissionsByEnvironment(Environment::TEST, UserRole::USER);

        Environment::assignPermissionsToRole(UserRole::ADMINISTRATOR, $administratorPermissions);
        Environment::assignPermissionsToRole(UserRole::MANAGER, $managerPermissions);
        Environment::assignPermissionsToRole(UserRole::USER, $userPermissions);
    }
}
