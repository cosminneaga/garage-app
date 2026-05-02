<?php

namespace App\Enums\Tabs;

use Illuminate\Support\Collection;

enum CompanyTabs: string
{
    case DETAILS = 'details';
    case STATISTICS = 'statistics';
    case USERS = 'users';
    case CONTACTS = 'contacts';
    case ADDRESSES = 'addresses';
    case SUPPLIERS = 'suppliers';

    public function label(): string
    {
        return match ($this) {
            self::DETAILS => 'Details',
            self::STATISTICS => 'Statistics',
            self::USERS => 'Members',
            self::CONTACTS => 'Contacts',
            self::ADDRESSES => 'Addresses',
            self::SUPPLIERS => 'Suppliers',
        };
    }

    public static function ui(): array
    {
        return new Collection(self::cases())
            ->map(fn($role) => [
                'value' => $role->value,
                'label' => $role->label(),
            ])->toArray();
    }

    public static function findByValue(string|null $value): false|string
    {
        if (self::tryFrom($value)) {
            return self::from($value)->value;
        }

        return false;
    }
}
