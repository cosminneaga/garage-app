<?php

use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Role;

test('isMyUser: true', function () {
    $administrator = User::factory()->create(['name' => 'administrator']);
    $administrator->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);
    $administrator->managers()->attach($manager);

    $user = User::factory()->create(['name' => 'user']);
    $user->assignRole(UserRole::USER);
    $manager->users()->attach($user);

    expect($administrator->isMyUser($user))->toBeTrue();
    expect($manager->isMyUser($user))->toBeTrue();
});

test('isMyUser: manager not attached, administrator -> false', function () {
    $administrator = User::factory()->create(['name' => 'administrator']);
    $administrator->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);

    $user = User::factory()->create(['name' => 'user']);
    $user->assignRole(UserRole::USER);
    $manager->users()->attach($user);

    expect($administrator->isMyUser($user))->toBeFalse();
    expect($manager->isMyUser($user))->toBeTrue();
});

test('isMyUser: user not attached, administrator & manager -> false', function () {
    $administrator = User::factory()->create(['name' => 'administrator']);
    $administrator->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);
    $administrator->managers()->attach($manager);

    $user = User::factory()->create(['name' => 'user']);
    $user->assignRole(UserRole::USER);

    expect($administrator->isMyUser($user))->toBeFalse();
    expect($manager->isMyUser($user))->toBeFalse();
});

test('isMyManager: true', function () {
    $administrator = User::factory()->create(['name' => 'administrator']);
    $administrator->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);
    $administrator->managers()->attach($manager);

    expect($administrator->isMyManager($manager))->toBeTrue();
});

test('isMyManager: false', function () {
    $administrator = User::factory()->create(['name' => 'administrator']);
    $administrator->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);

    expect($administrator->isMyManager($manager))->toBeFalse();
});


test('managers: from administrator to managers and user to managers', function () {
    $administrator = User::factory()->create(['name' => 'administrator']);
    $administrator->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);
    $administrator->managers()->attach($manager);

    $user = User::factory()->create(['name' => 'user']);
    $user->assignRole(UserRole::USER);
    $manager->users()->attach($user);

    expect($administrator->managers()->get())->toHaveCount(1);
    expect($administrator->managers()->get()[0])->toMatchArray(['name' => 'manager']);
    expect($user->managers()->get())->toHaveCount(1);
    expect($user->managers()->get()[0])->toMatchArray(['name' => 'manager']);
});

test('isMyUser: success on manager', function () {
    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);

    $user = User::factory()->create();
    $manager->users()->attach($user);

    $extUser = User::factory()->create();

    expect($manager->isMyUser($user))->toEqual(true);
    expect($manager->isMyUser($extUser))->toEqual(false);
});

test('isMyUser: success on administrator', function () {
    $administrator = User::factory()->create(['name' => 'administrator']);
    $administrator->assignRole(UserRole::ADMINISTRATOR);

    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::MANAGER);
    $administrator->managers()->attach($manager);

    $user = User::factory()->create();
    $manager->users()->attach($user);

    $extUser = User::factory()->create();

    expect($administrator->isMyUser($user))->toEqual(true);
    expect($administrator->isMyUser($extUser))->toEqual(false);
});

test('isMyUser: fail no role', function () {
    $manager = User::factory()->create(['name' => 'manager']);
    $user = User::factory()->create();

    expect(fn () => $manager->isMyUser($user))->toThrow('The user must hold a valid role');
});

test('isMyUser: fail wrong role', function () {
    $manager = User::factory()->create(['name' => 'manager']);
    Role::create(['name' => 'mailman']);
    $manager->assignRole('mailman');
    $user = User::factory()->create();

    expect(fn () => $manager->isMyUser($user))->toThrow('The user must hold a valid role');
});
