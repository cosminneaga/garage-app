<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

test('references', function () {
    expect(UserPermission::references())->toMatchArray(
        Collection::make(UserPermission::cases())->map(fn ($case) => $case->value)
    );
});

test('name: success', function () {
    expect(UserPermission::name(UserPermission::USER, 'show'))
        ->toEqual('user-show');
});

test('name: fail', function () {
    expect(fn () => UserPermission::name(UserPermission::USER, 'populate'))
        ->toThrow('Action: populate does not exists in: show,store,update,delete,restore');
});

test('list: exclude references & actions', function () {
    expect(UserPermission::list(
        excludeReferences: ['company'],
        excludeActions: ['show'],
    ))->toMatchArray(
        Collection::make(UserPermission::cases())
            ->reject(fn ($case) => $case->value === 'company')
            ->map(fn ($reference) => Collection::make(UserPermission::actions())
                ->except('show')
                ->map(fn ($action) => $reference->value . '-' . $action)
                ->values())->flatten()->toArray()
    );
});

test('list: only references & actions', function () {
    expect(UserPermission::list(
        onlyReferences: ['company'],
        onlyActions: ['show'],
    ))->toMatchArray([
        'company-show',
    ]);
});

# this test represent a sample of all 3 different types of data structure
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
