<?php

use App\Enums\UserRole;
use App\Models\Address;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);

    $this->manager = User::factory()->create();
    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();

    $this->manager_address = Address::factory()->create(['coordinates' => null]);
    $this->company_address = Address::factory()->create(['coordinates' => null]);
    $this->supplier_address = Address::factory()->create(['coordinates' => null]);
    $this->manager->addresses()->attach($this->manager_address);
    $this->company->addresses()->attach($this->company_address);
    $this->supplier->addresses()->attach($this->supplier_address);
});

test('administrator: should edit manager\'s address', function () {
    $this->administrator->managers()->attach($this->manager);
    actingAs($this->administrator);

    visit(route('addresses.users.edit', [$this->manager_address, $this->manager]))
        ->assertValue('@address_street_number', $this->manager_address->street_number)
        ->assertValue('@address_street', $this->manager_address->street)
        ->fill('@address_street_number', '9090')
        ->fill('@address_street', 'Sunflower Street')
        ->fill('@address_postcode', '74466-9381')
        ->click('@address_update')
        ->assertSee('Resource updated')
        ->assertSee('Address updated successfully')
        ->assertValue('@address_street_number', '9090')
        ->assertValue('@address_street', 'Sunflower Street')
        ->assertValue('@address_postcode', '74466-9381');
});

test('administrator: should edit company address', function () {
    $this->administrator->companies()->attach($this->company);
    actingAs($this->administrator);

    visit(route('addresses.companies.edit', [$this->company_address, $this->company]))
        ->assertValue('@address_street_number', $this->company_address->street_number)
        ->assertValue('@address_street', $this->company_address->street)
        ->fill('@address_street_number', '9090')
        ->fill('@address_street', 'Sunflower Street')
        ->fill('@address_postcode', '74466-9381')
        ->click('@address_update')
        ->assertSee('Resource updated')
        ->assertSee('Address updated successfully')
        ->assertValue('@address_street_number', '9090')
        ->assertValue('@address_street', 'Sunflower Street')
        ->assertValue('@address_postcode', '74466-9381');
});

test('administrator: should edit supplier address', function () {
    $this->administrator->companies()->attach($this->company);
    $this->company->suppliers()->attach($this->supplier);
    actingAs($this->administrator);

    visit(route('addresses.suppliers.edit', [$this->supplier_address, $this->supplier]))
        ->assertValue('@address_street_number', $this->supplier_address->street_number)
        ->assertValue('@address_street', $this->supplier_address->street)
        ->fill('@address_street_number', '9090')
        ->fill('@address_street', 'Sunflower Street')
        ->fill('@address_postcode', '74466-9381')
        ->click('@address_update')
        ->assertSee('Resource updated')
        ->assertSee('Address updated successfully')
        ->assertValue('@address_street_number', '9090')
        ->assertValue('@address_street', 'Sunflower Street')
        ->assertValue('@address_postcode', '74466-9381');
});
