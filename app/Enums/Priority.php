<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\HasEnumOptions;

enum Priority: string
{
    use HasEnumOptions;

    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
    case EMERGENCY = 'emergency';

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Low',
            self::NORMAL => 'Normal',
            self::HIGH => 'High',
            self::EMERGENCY => 'Emergency',
        };
    }
}
