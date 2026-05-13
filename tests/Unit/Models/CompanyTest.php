<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

test('should pass if company belongs to admin', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_ADMIN->value);

    $resource = Company::factory()->create();
    $resource->users()->attach($user);

    expect($resource->isMyCompany($user))->toBeTrue();
});

test('should pass if company belongs to user\'s manager', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);
    $manager->team()->attach($user);

    $resource = Company::factory()->create();
    $resource->users()->attach($manager);
    $resource->users()->attach($user);

    expect($resource->isMyCompany($user))->toBeTrue();
});

test('should fail if user has no role assigned', function () {
    $user = User::factory()->create();

    $resource = Company::factory()->create();
    $resource->users()->attach($user);

    expect($resource->isMyCompany($user))->toBeFalse();
});

test('should fail if user has no manager', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);

    $resource = Company::factory()->create();
    $resource->users()->attach($manager);
    $resource->users()->attach($user);

    expect($resource->isMyCompany($user))->toBeFalse();
});

test('should fail if user is not part of manager\'s team', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);

    $resource = Company::factory()->create();
    $resource->users()->attach($manager);
    $resource->users()->attach($user);

    expect($resource->isMyCompany($user))->toBeFalse();
});

test('should fail if supplier belongs to user\'s manager, but user is not linked to given company', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);
    $manager->team()->attach($user);

    $resource = Company::factory()->create();
    $resource->users()->attach($manager);

    expect($resource->isMyCompany($user))->toBeFalse();
});

test('find a supplier by name', function () {
    $company = Company::factory()->create();
    $supplier = Supplier::factory()->create();

    $company->suppliers()->attach($supplier);

    $found = $company->findSupplierByName($supplier->name);

    expect($found->name)->toEqual($supplier->name);
});
