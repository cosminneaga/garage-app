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
    case APPOINTMENT_START = 'appointment_start';
    case APPOINTMENT_FINISH = 'appointment_finish';
    case ESTIMATED_DURATION_MINUTES = 'estimated_duration_minutes';
    case ESTIMATED_COST = 'estimated_cost';

}
