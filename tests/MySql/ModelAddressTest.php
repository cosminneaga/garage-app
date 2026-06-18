<?php

use App\Dto\Coordinates;
use App\Models\Address;
use App\Models\Country;

test('coordinates: set/get', function () {
    $country = Country::factory()->create();

    $resource = Address::create([
        'number' => 123,
        'street' => 'Flowers Street',
        'postcode' => 212212,
        'extra' => 'Just around the corner.',
        'coordinates' => [
            'latitude' => 4.895168,
            'longitude' => 52.370216,
        ],
        'country_id' => $country->id,
    ]);

    expect($resource->coordinates->latitude)->toEqual(4.895168);
    expect($resource->coordinates->longitude)->toEqual(52.370216);

});

test('coordinates: set/get using Coordinates DTO', function () {
    $country = Country::factory()->create();

    $resource = Address::create([
        'number' => 123,
        'street' => 'Flowers Street',
        'postcode' => 212212,
        'extra' => 'Just around the corner.',
        'coordinates' => new Coordinates(4.895168, 52.370216),
        'country_id' => $country->id,
    ]);

    expect($resource->coordinates->latitude)->toEqual(4.895168);
    expect($resource->coordinates->longitude)->toEqual(52.370216);

});

test('withCoordinates scope', function () {
    $country = Country::factory()->create();

    Address::create([
        'number' => 123,
        'street' => 'Flowers Street',
        'postcode' => 212212,
        'extra' => 'Just around the corner.',
        'coordinates' => [
            'latitude' => 4.895168,
            'longitude' => 52.370216,
        ],
        'country_id' => $country->id,
    ]);

    $resource = Address::withCoordinates()->first();
    expect($resource)->toMatchArray([
        'number' => 123,
        'street' => 'Flowers Street',
        'postcode' => 212212,
        'extra' => 'Just around the corner.',
        'latitude' => 4.895168,
        'longitude' => 52.370216,
        'country_id' => $country->id,
    ]);
});

test('updateOrCreateByCoordinates: create resource', function () {
    $country = Country::factory()->create();

    $resource = Address::updateOrCreateByCoordinates(
        latitude: '4.895168',
        longitude: '52.370216',
        attributes: [
            'number' => 123,
            'street' => 'Flowers Street',
            'postcode' => 212212,
            'extra' => 'Just around the corner.',
            'country_id' => $country->id,
        ],
    );

    expect($resource->coordinates->latitude)->toEqual(4.895168);
    expect($resource->coordinates->longitude)->toEqual(52.370216);
});

test('updateOrCreateByCoordinates: update existing resource', function () {
    $country = Country::factory()->create();

    Address::updateOrCreateByCoordinates(
        latitude: '4.895168',
        longitude: '52.370216',
        attributes: [
            'number' => 123,
            'street' => 'Flowers Street',
            'postcode' => 212212,
            'extra' => 'Just around the corner.',
            'country_id' => $country->id,
        ],
    );

    $updatedresource = Address::updateOrCreateByCoordinates(
        latitude: '4.895168',
        longitude: '52.370216',
        attributes: [
            'number' => 321,
            'street' => 'SunFlowers Street',
            'postcode' => 555555,
            'extra' => 'Just around the corner, by the back yard.',
            'country_id' => $country->id,
        ],
    );

    expect($updatedresource->coordinates->latitude)->toEqual(4.895168);
    expect($updatedresource->coordinates->longitude)->toEqual(52.370216);

    $addresses = Address::all();
    expect($addresses)->toHaveCount(1);
});

test('updateOrCreateByCoordinates: create new resource', function () {
    $country = Country::factory()->create();

    $resource = Address::updateOrCreateByCoordinates(
        latitude: '4.895168',
        longitude: '52.370216',
        attributes: [
            'number' => 123,
            'street' => 'Flowers Street',
            'postcode' => 212212,
            'extra' => 'Just around the corner.',
            'country_id' => $country->id,
        ],
    );

    $newresource = Address::updateOrCreateByCoordinates(
        latitude: '4.895168',
        longitude: '52.370217',
        attributes: [
            'number' => 321,
            'street' => 'SunFlowers Street',
            'postcode' => 555555,
            'extra' => 'Just around the corner, by the back yard.',
            'country_id' => $country->id,
        ],
    );

    expect($resource->coordinates->latitude)->toEqual(4.895168);
    expect($resource->coordinates->longitude)->toEqual(52.370216);
    expect($newresource->coordinates->latitude)->toEqual(4.895168);
    expect($newresource->coordinates->longitude)->toEqual(52.370217);

    $addresses = Address::all();
    expect($addresses)->toHaveCount(2);
});
