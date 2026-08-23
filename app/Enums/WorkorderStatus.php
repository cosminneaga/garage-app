<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Collection;

enum WorkorderStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case PAUSED = 'paused';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::PAUSED => 'Paused',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function values(): array
    {
        return Collection::make(self::cases())
            ->map(fn (WorkorderStatus $case) => $case->value)
            ->toArray();
    }
}
