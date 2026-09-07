<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasEnumOptions
{
    public static function labels(): Collection
    {
        return Collection::make(self::cases())
            ->map(fn ($case) => Str::headline($case->value));
    }

    public static function values(): Collection
    {
        return Collection::make(self::cases())
            ->map(fn ($case) => $case->value);
    }

    public static function tableUI(): Collection
    {
        return Collection::make(self::cases())
            ->map(fn ($case) => [
                'label' => Str::headline($case->value),
                'value' => $case->value,
            ]);
    }
}
