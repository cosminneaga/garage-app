<?php

namespace App\Enums\TableMap;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum BookingTableMap: string
{
    case ID = 'id';
    case NUMBER = 'number';
    case STATUS = 'status';
    case SERVICE_TYPE = 'service_type';
    case PRIORITY = 'priority';
    case APPOINTMENT_START = 'appointment_start';
    case APPOINTMENT_FINISH = 'appointment_finish';
    case ESTIMATED_DURATION_MINUTES = 'estimated_duration_minutes';
    case ESTIMATED_COST = 'estimated_cost';
    case CHECKED_IN_AT = 'checked_in_at';
    case CANCELLED_AT = 'cancelled_at';
    case COMPLETED_AT = 'completed_at';
    case IN_REVIEW_AT = 'in_review_at';
    case IN_PROGRESS_AT = 'in_progress_at';
    case COMPANY_ID = 'company_id';
    case CLIENT_ID = 'client_id';
    case VEHICLE_ID = 'vehicle_id';
    case ADVISOR_ID = 'advisor_id';

    public static function labels(): Collection
    {
        return Collection::make(self::cases())
            ->map(fn (BookingTableMap $case) => Str::headline($case->value));
    }

    public static function values(): Collection
    {
        return Collection::make(self::cases())
            ->map(fn (BookingTableMap $case) => $case->value);
    }
}
