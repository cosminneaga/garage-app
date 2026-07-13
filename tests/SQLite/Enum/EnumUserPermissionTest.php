<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

test('tableStructure: showcases 3 different data structure used to assemble data for table', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);

    $permission = Permission::findOrCreate('vehicle_year-update');
    $user->givePermissionTo(UserPermission::name(UserPermission::VEHICLE_YEAR, 'update'));
    $table = UserPermission::tableStructure($user->getAllPermissions());
    $storedPermission = Permission::all()->last()->first();

    expect($table)->toBeInstanceOf(Collection::class);
    expect($table)->toMatchArray([
        [
            'id' => $permission->id,
            'name' => $permission->name,
            'guard_name' => $permission->guard_name,
            'created_at' => $permission->created_at->toJSON(),
            'updated_at' => $permission->updated_at->toJSON(),
            'pivot' => [
                'model_type' => User::class,
                'model_id' => $user->id,
                'permission_id' => $permission->id,
            ],
        ],
        [
            'id' => null,
            'name' => 'address-store',
            'guard_name' => 'web',
            'created_at' => null,
            'updated_at' => null,
            'available' => true,
        ],
    ]);
    expect($table->last()->first()->toArray())->toMatchArray([
        'id' => $storedPermission->id,
        'name' => $storedPermission->name,
        'guard_name' => $storedPermission->guard_name,
        'created_at' => $storedPermission->created_at,
        'updated_at' => $storedPermission->updated_at,
    ]);
});
