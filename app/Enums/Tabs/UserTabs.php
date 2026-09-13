<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use App\Traits\HasEnumOptions;

enum UserTabs: string
{
    use HasEnumOptions;

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
}
