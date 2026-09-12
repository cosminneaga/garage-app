<?php

declare(strict_types=1);

namespace App\Traits;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasEnumOptions
{
    abstract public static function cases(): array;
    abstract public static function from(int|string $value): static;
    abstract public static function tryFrom(int|string $value): ?static;

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

    public static function selectOptions(): Collection
    {
        return Collection::make(self::cases())
            ->map(fn ($case) => (object) [
                'label' => Str::headline($case->value),
                'value' => $case->value,
            ]);
    }

    public static function tabs(): Collection
    {
        if (!method_exists(self::class, 'label')) {
            throw new Exception('Method "label" does not exists on ' . self::class);
        }

        return Collection::make(self::cases())
            ->map(fn ($case) => (object) [
                'label' => $case->label(),
                'value' => $case->value,
                'slug' => Str::plural($case->value),
            ]);
    }

    public static function tableColumns(): Collection
    {
        return Collection::make(self::cases())
            ->map(fn ($case) => (object) [
                'value' => $case->value,
                'label' => Str::upper(Str::replace('_', ' ', $case->value)),
            ]);
    }

    public static function findByValue(?string $value): false|string
    {
        $case = self::tryFrom($value);

        return $case?->value ?? false;
    }

    public static function getLabel(mixed $name): string
    {
        if (!method_exists(self::class, 'label')) {
            throw new Exception('Method "label" does not exists on ' . self::class);
        }

        return Collection::make(self::cases())
            ->first(fn ($item) => $item->value === $name->value)->label();
    }
}
