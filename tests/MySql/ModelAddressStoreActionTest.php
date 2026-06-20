<?php

use App\Actions\ModelAddressStoreAction;
use App\Dto\Coordinates;
use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->company = Company::factory()->create();
    $this->supplier = Supplier::factory()->create();

    $this->country = Country::factory()->create();
    $this->action = new ModelAddressStoreAction();
});

test('should store address for user', function () {
    $this->action->handle([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $this->user);

    expect($this->user->addresses)->toHaveCount(1);
});

test('should store address for company', function () {
    $this->action->handle([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $this->company);

    expect($this->company->addresses)->toHaveCount(1);
});

test('should store address for supplier', function () {
    $this->action->handle([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $this->supplier);

    expect($this->supplier->addresses)->toHaveCount(1);
});

test('should not create a new resource if exists', function () {
    Address::factory()->create([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ]);

    expect(fn () => $this->action->handle([
        'street_number' => 1234,
        'street' => 'Sunflowers Street',
        'postcode' => 'B546BNS',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $this->supplier))->toThrow('Address already exists under same coordinates.');
});
