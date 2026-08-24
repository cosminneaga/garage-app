<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Collection;

enum ServiceType: string
{
    case MOT = 'mot';
    case SERVICE = 'service';
    case REPAIR = 'repair';
    case DIAGONISE = 'diagnose';

    public function label(): string
    {
        return match($this) {
            self::MOT => 'MOT',
            self::SERVICE => 'Service',
            self::REPAIR => 'Repair',
            self::DIAGONISE => 'Diagnose',
        };
    }

    public static function values(): array
    {
        return Collection::make(self::cases())
            ->map(fn (ServiceType $case) => $case->value)
            ->toArray();
    }
}
