<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();
    $this->company->suppliers()->attach($this->supplier);
    $this->administrator->companies()->attach($this->company);
});

test('administrator: should update existing supplier', function () {
    actingAs($this->administrator);
    visit(route('suppliers.companies.edit', [$this->supplier, $this->company]))
        ->assertValue('@supplier_name', $this->supplier->name)
        ->fill('@supplier_name', 'Supplier of AutoParts')
        ->click('@supplier_update_submit')
        ->assertSee('Supplier updated')
        ->assertSee('Supplier information has been successfully updated to respective company')
        ->assertValue('@supplier_name', 'Supplier of AutoParts');
});

test('super: update a supplier', function () {
    $super = User::factory()->create();
    $super->assignRole(UserRole::SUPER);
    actingAs($super);

    visit(route('super.suppliers.edit', [$this->supplier, $this->company]))
        ->assertValue('@supplier_name', $this->supplier->name)
        ->fill('@supplier_name', 'Supplier of AutoParts')
        ->click('@supplier_update_submit')
        ->assertSee('Supplier updated')
        ->assertSee('Supplier information has been successfully updated')
        ->assertValue('@supplier_name', 'Supplier of AutoParts');
});
