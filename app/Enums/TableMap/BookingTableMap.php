<?php

declare(strict_types=1);

namespace App\Enums\TableMap;

use App\Traits\HasEnumOptions;

enum BookingTableMap: string
{
    use HasEnumOptions;

    case ID = 'id';
    case NUMBER = 'number';
    case STATUS = 'status';
    case SERVICE_TYPE = 'service_type';
    case PRIORITY = 'priority';
}
