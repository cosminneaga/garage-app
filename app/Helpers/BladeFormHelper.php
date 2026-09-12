<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BladeFormHelper
{
    public static function testName(string $identifier, string $name): string
    {
        return $identifier . '_' . Str::replace(['[', ']'], ['_', ''], $name);
    }

    public static function errorName(string $name): string
    {
        return Str::replace(['[', ']'], ['.', ''], $name);
    }

    public static function names(string $identifier, string $name): Collection
    {
        return Collection::make([
            'testName' => self::testName($identifier, $name),
            'errorName' => self::errorName($name),
        ]);
    }
}
