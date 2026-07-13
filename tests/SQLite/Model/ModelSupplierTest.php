<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->administrator->managers()->attach($this->manager);

    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::USER);
    $this->manager->users()->attach($this->user);

    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();
});

test('isMySupplier', function () {
    $this->company->users()->attach([
        $this->administrator,
        $this->manager,
        $this->user,
    ]);
    $this->company->suppliers()->attach($this->supplier);

    expect($this->company->users()->get())->toHaveCount(3);
    expect($this->company->suppliers()->get())->toHaveCount(1);
    expect($this->supplier->isMySupplier($this->administrator))->toBeTrue();
    expect($this->supplier->isMySupplier($this->manager))->toBeTrue();
    expect($this->supplier->isMySupplier($this->user))->toBeTrue();

    $this->company->suppliers()->detach($this->supplier);

    expect($this->company->users()->get())->toHaveCount(3);
    expect($this->company->suppliers()->get())->toHaveCount(0);
    expect($this->supplier->isMySupplier($this->administrator))->toBeFalse();
    expect($this->supplier->isMySupplier($this->manager))->toBeFalse();
    expect($this->supplier->isMySupplier($this->user))->toBeFalse();
});
