<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum BookingColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case NUMBER = 'number';
    case STATUS = 'status';
    case SERVICE_TYPE = 'service_type';
    case PRIORITY = 'priority';
    case CONFIRMED_AT = 'confirmed_at';
    case CHECKED_IN_AT = 'checked_in_at';
    case ESTIMATED_DURATION_MINUTES = 'estimated_duration_minutes';
    case ESTIMATED_COST = 'estimated_cost';

}
