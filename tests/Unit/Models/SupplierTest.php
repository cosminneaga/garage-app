<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;


test('should pass if supplier belongs to admin', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_ADMIN->value);

    $company = Company::factory()->create();
    $company->users()->attach($user);

    $supplier = Supplier::factory()->create();
    $company->suppliers()->attach($supplier);

    expect($supplier->isMySupplier($user))->toBeTrue();
});

test('should pass if supplier belongs to user\'s manager', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);
    $manager->team()->attach($user);

    $company = Company::factory()->create();
    $company->users()->attach($manager);
    $company->users()->attach($user);

    $supplier = Supplier::factory()->create();
    $company->suppliers()->attach($supplier);

    expect($supplier->isMySupplier($user))->toBeTrue();
});

test('should fail if user has no role assigned', function () {
    $user = User::factory()->create();

    $company = Company::factory()->create();
    $company->users()->attach($user);

    $supplier = Supplier::factory()->create();
    $company->suppliers()->attach($supplier);

    expect($supplier->isMySupplier($user))->toBeFalse();
});

test('should fail if user has no manager', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);

    $company = Company::factory()->create();
    $company->users()->attach($user);

    $supplier = Supplier::factory()->create();
    $company->suppliers()->attach($supplier);

    expect($supplier->isMySupplier($user))->toBeFalse();
});

test('should fail if user is not part of manager\'s team', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);

    $company = Company::factory()->create();
    $company->users()->attach($manager);
    $company->users()->attach($user);

    $supplier = Supplier::factory()->create();
    $company->suppliers()->attach($supplier);

    expect($supplier->isMySupplier($user))->toBeFalse();
});

test('should fail if supplier belongs to user\'s manager, but user is not linked to given company', function () {
    $manager = User::factory()->create();
    $manager->assignRole(UserRole::USER_ADMIN->value);

    $user = User::factory()->create();
    $user->assignRole(UserRole::USER_EDITOR->value);
    $manager->team()->attach($user);

    $company = Company::factory()->create();
    $company->users()->attach($manager);

    $supplier = Supplier::factory()->create();
    $company->suppliers()->attach($supplier);

    expect($supplier->isMySupplier($user))->toBeFalse();
});
