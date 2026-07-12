<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

test('tableStructure', function () {

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);

    Permission::findOrCreate('vehicle_year-update');
    $user->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_YEAR, 'update'));

    $table = UserPermission::tableStructure($user->getAllPermissions());

    expect($table)->toBeInstanceOf(Collection::class);
});
