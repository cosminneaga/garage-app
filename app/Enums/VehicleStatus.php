<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Collection;

enum VehicleStatus: string
{
    case ACTIVE = 'active';
    case AWAITING_PARTS = 'awaiting_parts';
    case IN_REPAIR = 'in_repair';
    case READY_FOR_COLLECTION = 'ready_for_collection';
    case DELIVERED = 'delivered';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::AWAITING_PARTS => 'Awaiting Parts',
            self::IN_REPAIR => 'In Repair',
            self::READY_FOR_COLLECTION => 'Ready for Collection',
            self::DELIVERED => 'Delivered',
        };
    }

    public function values(): array
    {
        return Collection::make(self::cases())
            ->map(fn (VehicleStatus $case) => $case->value)
            ->toArray();
    }
}
