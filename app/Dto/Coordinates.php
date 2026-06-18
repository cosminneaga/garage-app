<?php

declare(strict_types=1);

namespace App\Dto;

use Exception;

class Coordinates
{
    public function __construct(
        public float|string $latitude,
        public float|string $longitude,
    ) {
        //
    }

    public static function format(mixed $value): Coordinates|null
    {
        return match (gettype($value)) {
            'array' => new Coordinates($value['latitude'], $value['longitude']),
            'object' => new Coordinates($value->latitude, $value->longitude),
            default => throw new Exception('Unknown value type: ' . gettype($value)),
        };
    }
}
