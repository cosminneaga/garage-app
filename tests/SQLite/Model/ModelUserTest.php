<?php

use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->manager = User::factory()->create();
    $this->user = User::factory()->create();

    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->user->assignRole(UserRole::USER);
});

/**
 * administrator -> managers
 * administrator -> users, as long as they are attached to existing manager
 * manager -> users
 * users -> users, at the moment by poiting to the first attached manager, subject to change in future
 */
test('isMyUser: attached & detached', function () {
    $external_user = User::factory()->create();
    $external_user->assignRole(UserRole::USER);

    # attach users
    $this->administrator->memberAttach($this->manager);
    $this->manager->memberAttach($this->user);
    $this->manager->memberAttach($external_user);

    expect($this->administrator->isMyUser($this->manager))->toBeTrue();
    expect($this->administrator->isMyUser($this->user))->toBeTrue();
    expect($this->manager->isMyUser($this->user))->toBeTrue();
    expect($this->manager->isMyUser($external_user))->toBeTrue();
    expect($this->user->isMyUser($external_user))->toBeTrue();

    # detach users
    $this->administrator->memberDetach($this->manager);
    $this->manager->memberDetach($this->user);
    $this->manager->memberDetach($external_user);

    expect($this->administrator->isMyUser($this->manager))->toBeFalse();
    expect($this->administrator->isMyUser($this->user))->toBeFalse();
    expect($this->manager->isMyUser($this->user))->toBeFalse();
    expect($this->manager->isMyUser($external_user))->toBeFalse();
    expect($this->user->isMyUser($external_user))->toBeFalse();
});

test('isMyUser: user has no role', function () {
    $norole_user = User::factory()->create();
    $this->manager->memberAttach($norole_user);
    expect($this->user->isMyUser($norole_user))->toBeFalse();
});

test('isMyUser: fail on manager\'s wrong role', function () {
    $manager = User::factory()->create(['name' => 'manager']);
    Role::create(['name' => 'mailman']);
    $manager->assignRole('mailman');
    $user = User::factory()->create();

    expect(fn () => $manager->isMyUser($user))->toThrow('The user must hold a valid role');
});

test('isMyManager: administrator', function () {
    # attach manager
    $this->administrator->memberAttach($this->manager);
    expect($this->administrator->isMyManager($this->manager))->toBeTrue();

    # detach manager
    $this->administrator->memberDetach($this->manager);
    expect($this->administrator->isMyManager($this->manager))->toBeFalse();
});

test('isMyManager: user', function () {
    # attach user
    $this->manager->memberAttach($this->user);
    expect(fn () => $this->user->isMyManager($this->manager))->toThrow('User data can only be access by an administrator');
});

test('managers: from administrator to managers and user to managers', function () {
    # attach users
    $this->administrator->memberAttach($this->manager);
    $this->manager->memberAttach($this->user);

    expect($this->administrator->managers()->get())->toHaveCount(1);
    expect($this->administrator->managers()->get()[0])->toMatchArray(['name' => $this->manager->name]);
    expect($this->user->managers()->get())->toHaveCount(1);
    expect($this->user->managers()->get()[0])->toMatchArray(['name' => $this->manager->name]);
});
