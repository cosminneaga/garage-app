<?php

declare(strict_types=1);

namespace App\Enums\Tabs;

use App\Traits\HasEnumOptions;

enum ClientTabs: string
{
    use HasEnumOptions;

    case DETAILS = 'details';
    case STATISTICS = 'statistics';
    case CONTACT = 'contact';
    case ADDRESS = 'address';
    case COMPANIES = 'companies';

    public function label(): string
    {
        return match ($this) {
            self::DETAILS => 'Details',
            self::STATISTICS => 'Statistics',
            self::CONTACT => 'Contact',
            self::ADDRESS => 'Address',
            self::COMPANIES => 'Companies',
        };
    }
}
