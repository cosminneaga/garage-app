<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use Illuminate\Support\Collection;

enum UserTabs: string
{
    case DETAILS = 'details';
    case STATISTICS = 'statistics';
    case CONTACTS = 'contacts';
    case ADDRESSES = 'addresses';
    case PERMISSIONS = 'permissions';

    public function label(): string
    {
        return match ($this) {
            self::DETAILS => 'Details',
            self::STATISTICS => 'Statistics',
            self::CONTACTS => 'Contacts',
            self::ADDRESSES => 'Addresses',
            self::PERMISSIONS => 'Permissions',
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::DETAILS => 'details',
            self::STATISTICS => 'statistics',
            self::CONTACTS => 'contacts',
            self::ADDRESSES => 'addresses',
            self::PERMISSIONS => 'permissions',
        };
    }

    public static function ui(): array
    {
        return Collection::make(self::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'slug' => $case->slug(),
            ])->toArray();
    }

    public static function findByValue(?string $value): false|string
    {
        if (self::tryFrom($value)) {
            return self::from($value)->value;
        }

        return false;
    }
}
