<?php

use App\Dto\Coordinates;

test('format: formatting data from given array type', function () {
    $data = Coordinates::format([
        'latitude' => 9.45365,
        'longitude' => 65.83928,
    ]);

    expect($data)->toBeInstanceOf(Coordinates::class);
    expect($data->latitude)->toEqual(9.45365);
    expect($data->longitude)->toEqual(65.83928);
});

test('format: formatting data from given object type', function () {
    $data = Coordinates::format((object) [
        'latitude' => 9.45365,
        'longitude' => 65.83928,
    ]);

    expect($data)->toBeInstanceOf(Coordinates::class);
    expect($data->latitude)->toEqual(9.45365);
    expect($data->longitude)->toEqual(65.83928);
});

test('format: null value', function () {
    $data = Coordinates::format(null);

    expect($data)->toEqual(null);
});

test('format: throw an exception if type is unknown', function () {
    expect(fn () => Coordinates::format(false))->toThrow('Unknown value type: boolean');
});
