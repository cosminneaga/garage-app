<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use App\Traits\HasEnumOptions;

enum SupplierTabs: string
{
    use HasEnumOptions;

    case DETAILS = 'details';
    case STATISTICS = 'statistics';
    case CONTACTS = 'contacts';
    case ADDRESSES = 'addresses';

    public function label(): string
    {
        return match ($this) {
            self::DETAILS => 'Details',
            self::STATISTICS => 'Statistics',
            self::CONTACTS => 'Contacts',
            self::ADDRESSES => 'Addresses',
        };
    }
}
