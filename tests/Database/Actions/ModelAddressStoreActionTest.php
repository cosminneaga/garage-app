<?php

use App\Actions\ModelAddressStoreAction;
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
        'number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'extra' => 'Extra Information',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->user);

    expect($this->user->addresses)->toHaveCount(1);
});

test('should store address for company', function () {
    $this->action->handle([
        'number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'extra' => 'Extra Information',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->company);

    expect($this->company->addresses)->toHaveCount(1);
});

test('should store address for supplier', function () {
    $this->action->handle([
        'number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'extra' => 'Extra Information',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->supplier);

    expect($this->supplier->addresses)->toHaveCount(1);
});

test('should link same address across resources if same coordinates', function () {
    $this->action->handle([
        'number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'extra' => 'Extra Information',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->user);
    $this->action->handle([
        'number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'extra' => 'Extra Information',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->company);
    $this->action->handle([
        'number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'extra' => 'Extra Information',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->supplier);

    $addresses = Address::all();

    expect($addresses)->toHaveCount(1);
    expect($this->user->addresses)->toHaveCount(1);
    expect($this->company->addresses)->toHaveCount(1);
    expect($this->supplier->addresses)->toHaveCount(1);
});

test('should update same address across resources if same coordinates', function () {
    $this->action->handle([
        'number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'extra' => 'Extra Information',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->user);
    $this->action->handle([
        'number' => 124,
        'street' => 'Sunflowers Street',
        'postcode' => 'B546BNv',
        'extra' => 'Extra Informations',
        'country_id' => $this->country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->company);

    $country = Country::factory()->create();
    $this->action->handle([
        'number' => 125,
        'street' => 'Sunflowerss Street',
        'postcode' => 'B546BNvv',
        'extra' => 'Extra Informationss',
        'country_id' => $country->id,
        'coordinates' => [
            'latitude' => 9.4784783,
            'longitude' => 34.4378747,
        ]
    ], $this->supplier);

    $addresses = Address::all();
    $address = Address::first();

    expect($addresses)->toHaveCount(1);
    expect($address)->toMatchArray([
        'number' => 125,
        'street' => 'Sunflowerss Street',
        'postcode' => 'B546BNvv',
        'extra' => 'Extra Informationss',
        'country_id' => $country->id,
    ]);
    expect($this->user->addresses)->toHaveCount(1);
    expect($this->company->addresses)->toHaveCount(1);
    expect($this->supplier->addresses)->toHaveCount(1);
});
