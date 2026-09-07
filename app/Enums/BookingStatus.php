<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\HasEnumOptions;

enum BookingStatus: string
{
    use HasEnumOptions;

    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CHECKED_IN = 'checked_in';
    case IN_PROGRESS = 'in_progress';
    case IN_REVIEW = 'in_review';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::CONFIRMED => 'Confirmed',
            self::CHECKED_IN => 'Checked In',
            self::IN_PROGRESS => 'In Progress',
            self::IN_REVIEW => 'In Review',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }
}
