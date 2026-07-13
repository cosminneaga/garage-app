<?php

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\User;

use function Pest\Laravel\actingAs;

test('can: verify auth & permission', function () {
    $user = User::factory()->create();
    $user->givePermissionTo(UserPermission::name(UserPermission::USER, 'update'));
    actingAs($user);

    expect(Permission::can(UserPermission::USER, 'update'))->toEqual(true);
});

test('can: should return "false" if user is not logged in', function () {
    $user = User::factory()->create();
    $user->givePermissionTo(UserPermission::name(UserPermission::USER, 'update'));

    expect(Permission::can(UserPermission::USER, 'update'))->toEqual(false);
});

test('can: should return "false" if user has assigned wrong permission', function () {
    $user = User::factory()->create();
    $user->givePermissionTo(UserPermission::name(UserPermission::USER, 'update'));
    actingAs($user);

    expect(Permission::can(UserPermission::USER, 'delete'))->toEqual(false);
});
