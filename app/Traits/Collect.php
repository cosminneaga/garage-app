<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Collection;

trait Collect
{
    public static function existsIn(array $givenList, array $compareList): bool
    {
        return (bool) new Collection($givenList)
            ->values()
            ->every(fn ($value) => in_array($value, $compareList));
    }
}
