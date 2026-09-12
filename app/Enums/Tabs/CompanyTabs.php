<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use App\Traits\HasEnumOptions;

enum CompanyTabs: string
{
    use HasEnumOptions;

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
}
