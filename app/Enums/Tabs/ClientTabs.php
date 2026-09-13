<?php

namespace App\Enums\Tabs;

use App\Traits\HasEnumOptions;

enum ClientTabs: string
{
    use HasEnumOptions;

    case DETAILS = 'details';
    case STATISTICS = 'statistics';
    case CONTACTS = 'contacts';
    case ADDRESSES = 'addresses';
    case COMPANIES = 'companies';

    public function label(): string
    {
        return match ($this) {
            self::DETAILS => 'Details',
            self::STATISTICS => 'Statistics',
            self::CONTACTS => 'Contacts',
            self::ADDRESSES => 'Addresses',
            self::COMPANIES => 'Companies',
        };
    }
}
