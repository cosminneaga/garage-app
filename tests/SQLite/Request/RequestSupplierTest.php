<?php

use App\Enums\SupplierType;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

beforeEach(function () {
    $this->super = User::factory()->create();
    $this->user = User::factory()->create();
    $this->super->assignRole(UserRole::SUPER);
    $this->user->assignRole(UserRole::USER);

    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();

    $this->company->users()->attach($this->user);
    $this->company->suppliers()->attach($this->supplier);

    $this->country = Country::factory()->create();
});

test('user: should see company supplier, by default', function () {
    actingAs($this->user);

    get(route('suppliers.companies.edit', [$this->supplier, $this->company]))
        ->assertSee($this->supplier->name);
});

test('user: [with permission] should update company supplier details', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::SUPPLIER, 'update'),
        Permission::value(UserPermission::COMPANY, 'update'),
    ]);
    actingAs($this->user);

    put(route('suppliers.companies.update', [$this->supplier, $this->company]), [
        'name' => 'Supplier',
        'code' => 'SUP',
        'type' => SupplierType::DISTRIBUTOR->value,
        'tax_id' => '39287398283782',
        'registration_number' => '3467286476234',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Supplier updated',
            'message' => 'Supplier information has been successfully updated to respective company',
        ]);
});

test('user: [with permissions] should store company supplier', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::SUPPLIER, 'store'),
        Permission::value(UserPermission::COMPANY, 'update'),
    ]);
    actingAs($this->user);

    post(route('suppliers.companies.store', $this->company), [
        'name' => 'Supplier',
        'code' => 'SUP',
        'type' => SupplierType::DISTRIBUTOR->value,
        'tax_id' => '39287398283782',
        'registration_number' => '3467286476234',
        'contact' => [
            'email' => 'sup@garage.com',
            'mobile' => '(736) 6372 546',
        ],
        'address' => [
            'street_number' => '5362',
            'street' => 'Street Name',
            'postcode' => 'B653HDG',
            'country_id' => $this->country->id,
        ],
    ])
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'success',
            'title' => 'Supplier created',
            'message' => 'Supplier information has been created and attached to respective company',
        ]);
});

test('user: [with permissions] should detach supplier from company', function () {
    $this->user->givePermissionTo([
        Permission::value(UserPermission::SUPPLIER, 'delete'),
        Permission::value(UserPermission::COMPANY, 'update'),
    ]);
    actingAs($this->user);

    delete(route('suppliers.companies.destroy', [$this->supplier, $this->company]))
        ->assertRedirectBack()
        ->assertSessionHas('message', (object) [
            'type' => 'info',
            'title' => 'Supplier removed',
            'message' => 'Supplier information has been successfully removed from respective company',
        ]);
});

test('super: only super should directly see supplier', function () {
    actingAs($this->super);
    get(route('super.suppliers.edit', $this->supplier))
        ->assertSee($this->supplier->name);

    actingAs($this->user);
    get(route('super.suppliers.edit', $this->supplier))
        ->assertForbidden();
});
