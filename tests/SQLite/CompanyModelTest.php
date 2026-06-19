<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR->value);

    $this->manager = User::factory()->create();
    $this->manager->assignRole(UserRole::MANAGER);
    $this->administrator->managers()->attach($this->manager);

    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::USER);
    $this->manager->users()->attach($this->user);

    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();
});


test('isMyCompany', function () {
    $this->administrator->companies()->attach($this->company);
    $this->manager->companies()->attach($this->company);
    $this->user->companies()->attach($this->company);

    expect($this->company->isMyCompany($this->administrator))->toBeTrue();
    expect($this->company->isMyCompany($this->manager))->toBeTrue();
    expect($this->company->isMyCompany($this->user))->toBeTrue();
});

test('findSupplierByName', function () {
    $this->company->suppliers()->attach($this->supplier);
    $result = $this->company->findSupplierByName($this->supplier->name);

    expect($result->name)->toEqual($this->supplier->name);
});
