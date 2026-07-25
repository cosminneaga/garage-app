<?php

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\Address;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->administrator = User::factory()->create();
    $this->manager = User::factory()->create();
    $this->user = User::factory()->create();
    $this->administrator->assignRole(UserRole::ADMINISTRATOR);
    $this->manager->assignRole(UserRole::MANAGER);
    $this->user->assignRole(UserRole::USER);

    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();

    $this->manager_address = Address::factory()->create(['coordinates' => null]);
    $this->user_address = Address::factory()->create(['coordinates' => null]);
    $this->company_address = Address::factory()->create(['coordinates' => null]);
    $this->supplier_address = Address::factory()->create(['coordinates' => null]);
    $this->manager->addresses()->attach($this->manager_address);
    $this->user->addresses()->attach($this->user_address);
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

test('administrator: should edit user\'s address', function () {
    $this->administrator->managers()->attach($this->manager);
    $this->manager->users()->attach($this->user);
    actingAs($this->administrator);

    visit(route('addresses.users.edit', [$this->user_address, $this->user]))
        ->assertValue('@address_street_number', $this->user_address->street_number)
        ->assertValue('@address_street', $this->user_address->street)
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



test('manager: should not be able to edit administrator\'s address', function () {
    $this->administrator->managers()->attach($this->manager);
    actingAs($this->manager);

    visit(route('addresses.users.edit', [$this->user_address, $this->administrator]))
        ->assertSee('401 Unauthorized');
});

test('manager: should edit user\'s address', function () {
    $this->manager->users()->attach($this->user);
    actingAs($this->manager);

    visit(route('addresses.users.edit', [$this->user_address, $this->user]))
        ->assertValue('@address_street_number', $this->user_address->street_number)
        ->assertValue('@address_street', $this->user_address->street)
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

test('manager: should edit company address', function () {
    $this->manager->companies()->attach($this->company);
    actingAs($this->manager);

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

test('manager: should edit supplier address', function () {
    $this->manager->companies()->attach($this->company);
    $this->company->suppliers()->attach($this->supplier);
    actingAs($this->manager);

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

test('user: should not edit manager\'s address', function () {
    $this->manager->users()->attach($this->user);
    actingAs($this->user);

    visit(route('addresses.users.edit', [$this->manager_address, $this->manager]))
        ->assertSee('401 Unauthorized');
});

test('user: should not edit administrator\'s address', function () {
    $this->administrator->managers()->attach($this->manager);
    $this->manager->users()->attach($this->user);
    actingAs($this->user);

    visit(route('addresses.users.edit', [$this->manager_address, $this->manager]))
        ->assertSee('401 Unauthorized');
});

test('user: should not edit user\'s address', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['coordinates' => null]);
    $user->assignRole(UserRole::USER);
    $user->addresses()->attach($address);
    $this->manager->users()->attach([$this->user, $user]);
    actingAs($this->user);

    visit(route('addresses.users.edit', [$address, $user]))
        ->assertValue('@address_street_number', $address->street_number)
        ->assertValue('@address_street', $address->street)
        ->click('@address_update')
        ->assertSee('401 Unauthorized');
});

test('user: with address permission only, should not edit user\'s address', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $address = Address::factory()->create(['coordinates' => null]);
    $user->addresses()->attach($address);
    $this->manager->users()->attach([$this->user, $user]);

    $this->user->givePermissionTo([
        Permission::value(UserPermission::ADDRESS, 'update'),
    ]);

    actingAs($this->user);

    visit(route('addresses.users.edit', [$address, $user]))
        ->assertValue('@address_street_number', $address->street_number)
        ->assertValue('@address_street', $address->street)
        ->click('@address_update')
        ->assertSee('401 Unauthorized');
});

test('user: with user permission only, should not edit user\'s address', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $address = Address::factory()->create(['coordinates' => null]);
    $user->addresses()->attach($address);
    $this->manager->users()->attach([$this->user, $user]);

    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
    ]);

    actingAs($this->user);

    visit(route('addresses.users.edit', [$address, $user]))
        ->assertValue('@address_street_number', $address->street_number)
        ->assertValue('@address_street', $address->street)
        ->click('@address_update')
        ->assertSee('403 this action is unauthorized');
});

test('user: with address & user permissions should edit user\'s address', function () {
    $user = User::factory()->create();
    $user->assignRole(UserRole::USER);
    $address = Address::factory()->create(['coordinates' => null]);
    $user->addresses()->attach($address);
    $this->manager->users()->attach([$this->user, $user]);

    $this->user->givePermissionTo([
        Permission::value(UserPermission::USER, 'update'),
        Permission::value(UserPermission::ADDRESS, 'update'),
    ]);

    actingAs($this->user);

    visit(route('addresses.users.edit', [$address, $user]))
        ->assertValue('@address_street_number', $address->street_number)
        ->assertValue('@address_street', $address->street)
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



test('user: with address & company permission, should edit company address', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::COMPANY, 'update'),
        Permission::value(UserPermission::ADDRESS, 'update'),
    ]);
    $this->company->users()->attach($this->user);

    actingAs($this->user);

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

test('user: with address & supplier permission, should edit supplier address', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::SUPPLIER, 'update'),
        Permission::value(UserPermission::ADDRESS, 'update'),
    ]);
    $this->company->users()->attach($this->user);
    $this->company->suppliers()->attach($this->supplier);

    actingAs($this->user);

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
