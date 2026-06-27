<?php

declare(strict_types=1);

namespace App\Dto;

use Exception;
use Throwable;

class Coordinates
{
    public function __construct(
        public float|string $latitude,
        public float|string $longitude,
    ) {
        //
    }

    public static function format(mixed $value): Coordinates|Throwable|null
    {
        switch (gettype($value)) {
            case 'array':
                if (!$value['latitude'] || !$value['longitude']) {
                    return null;
                }

                return new Coordinates($value['latitude'], $value['longitude']);
            case 'object':
                if (!$value->latitude || !$value->longitude) {
                    return null;
                }

                return new Coordinates($value->latitude, $value->longitude);
            case 'NULL':
                return null;
            default:
                throw new Exception('Unknown value type: ' . gettype($value));
        }
    }
}
