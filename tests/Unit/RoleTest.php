<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Spatie\Permission\Models\Role;

test('only admin should be able to delete users', function () {
    $this->seed(PermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole(UserRole::SUPER->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_ADMIN->value);

    $testingUser = User::factory()->create();

    $response = $this->actingAs($user)->delete(route('users.destroy', $testingUser));
    $response->assertStatus(403);

    $response = $this->actingAs($admin)->delete(route('users.destroy', $testingUser));
    $response->assertStatus(302);
});

test('users with users-delete permission should be able to delete users', function () {
    $this->seed(PermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole(UserRole::SUPER->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_ADMIN->value);
    $userAdminRole = Role::findOrCreate(UserRole::USER_ADMIN->value, 'web');
    $userAdminRole->givePermissionTo(UserPermission::name(UserPermission::USER, 'delete'));

    $testingUser = User::factory()->create();

    $response = $this->actingAs($user)->delete(route('users.destroy', $testingUser));
    $response->assertStatus(302);

    $response = $this->actingAs($admin)->delete(route('users.destroy', $testingUser));
    $response->assertStatus(302);
});
