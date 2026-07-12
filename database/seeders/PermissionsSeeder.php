<?php

namespace Database\Seeders;

use App\Enums\Environment;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        App::make(PermissionRegistrar::class)->forgetCachedPermissions();
        Environment::insertRoles();
        Environment::insertPermissions();

        $administratorPermissions = Environment::insertPermissionsByEnvironment(Environment::LOCAL, UserRole::ADMINISTRATOR);
        $managerPermissions = Environment::insertPermissionsByEnvironment(Environment::LOCAL, UserRole::MANAGER);
        $userPermissions = Environment::insertPermissionsByEnvironment(Environment::LOCAL, UserRole::USER);

        Environment::assignPermissionsToRole(UserRole::ADMINISTRATOR, $administratorPermissions);
        Environment::assignPermissionsToRole(UserRole::MANAGER, $managerPermissions);
        Environment::assignPermissionsToRole(UserRole::USER, $userPermissions);
    }
}
