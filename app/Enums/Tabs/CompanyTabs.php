<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use Illuminate\Support\Collection;

enum CompanyTabs: string
{
    case DETAILS = 'details';
    case STATISTICS = 'statistics';
    case MEMBERS = 'members';
    case CONTACTS = 'contacts';
    case ADDRESSES = 'addresses';
    case SUPPLIERS = 'suppliers';
    case VEHICLES = 'vehicles';
    case CLIENTS = 'clients';

    public function label(): string
    {
        return match ($this) {
            self::DETAILS => 'Details',
            self::STATISTICS => 'Statistics',
            self::MEMBERS => 'Members',
            self::CONTACTS => 'Contacts',
            self::ADDRESSES => 'Addresses',
            self::SUPPLIERS => 'Suppliers',
            self::VEHICLES => 'Vehicles',
            self::CLIENTS => 'Clients',
        };
    }

    public function slug(): string
    {
        return match ($this) {
            self::DETAILS => 'details',
            self::STATISTICS => 'statistics',
            self::MEMBERS => 'members',
            self::CONTACTS => 'contacts',
            self::ADDRESSES => 'addresses',
            self::SUPPLIERS => 'suppliers',
            self::VEHICLES => 'vehicles',
            self::CLIENTS => 'clients',
        };
    }

    public static function ui(): array
    {
        return new Collection(self::cases())
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
