<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create();
    $this->admin->assignRole(UserRole::USER_ADMIN->value);

    $this->company = Company::factory()->create();
    $this->admin->companies()->attach($this->company);

    $this->supplier = Supplier::factory()->create();
    $this->company->suppliers()->attach($this->supplier);
});


test('isMyCompany', function () {
    expect($this->company->isMyCompany($this->admin))->toBeTrue();
});

test('findSupplierByName', function () {
    $result = $this->company->findSupplierByName($this->supplier->name);

    expect($result->name)->toEqual($this->supplier->name);
});
