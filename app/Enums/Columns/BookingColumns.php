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
    case ESTIMATED_DURATION_HOURS = 'estimated_duration_hours';
    case ESTIMATED_COST = 'estimated_cost';

}
