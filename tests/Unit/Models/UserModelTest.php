<?php

use App\Enums\UserRole;
use App\Models\User;

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

test('isMyUser: fail wrong role', function () {
    $manager = User::factory()->create(['name' => 'manager']);
    $manager->assignRole(UserRole::USER);

    $user = User::factory()->create();
    $manager->users()->attach($user);

    $extUser = User::factory()->create();


    expect(fn () => $manager->isMyUser($user))->toThrow('The user must hold the manager or administrator role.');
    expect(fn () => $manager->isMyUser($extUser))->toThrow('The user must hold the manager or administrator role.');
});

test('isMyUser: fail no role', function () {
    $manager = User::factory()->create(['name' => 'manager']);

    $user = User::factory()->create();
    $manager->users()->attach($user);

    $extUser = User::factory()->create();


    expect(fn () => $manager->isMyUser($user))->toThrow('The user must hold the manager or administrator role.');
    expect(fn () => $manager->isMyUser($extUser))->toThrow('The user must hold the manager or administrator role.');
});
