<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Collection;

test('tableStructure', function () {

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $user->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_YEAR, 'update'));

    $table = UserPermission::tableStructure($user->getAllPermissions());

    expect($table)->toBeInstanceOf(Collection::class);
});
