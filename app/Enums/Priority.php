<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Collection;

enum Priority: string
{
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

    public function values(): array
    {
        return Collection::make(self::cases())
            ->map(fn (Priority $case) => $case->value)
            ->toArray();
    }
}
