<?php

use App\Actions\ModelAddressStoreAction;
use App\Dto\Coordinates;
use App\Models\Address;
use App\Models\Company;
use App\Models\Country;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    $this->country = Country::factory()->create();
});

test('handle: store address for an user', function () {
    $user = User::factory()->create();

    App::make(ModelAddressStoreAction::class)->handle([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $user);

    expect($user->addresses)->toHaveCount(1);
});

test('handle: store address for a company', function () {
    $company = Company::factory()->create();

    App::make(ModelAddressStoreAction::class)->handle([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $company);

    expect($company->addresses)->toHaveCount(1);
});

test('handle: store address for a supplier', function () {
    $supplier = Supplier::factory()->create();

    App::make(ModelAddressStoreAction::class)->handle([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $supplier);

    expect($supplier->addresses)->toHaveCount(1);
});

test('handle: throw an error if same coordinates', function () {
    $user = User::factory()->create();
    Address::factory()->create([
        'street_number' => 123,
        'street' => 'Sunflower Street',
        'postcode' => 'B546BN',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ]);

    expect(fn () => App::make(ModelAddressStoreAction::class)->handle([
        'street_number' => 1234,
        'street' => 'Sunflowers Street',
        'postcode' => 'B546BNS',
        'country_id' => $this->country->id,
        'coordinates' => new Coordinates(9.4784783, 34.4378747),
    ], $user))->toThrow('Address already exists under same coordinates.');
});
