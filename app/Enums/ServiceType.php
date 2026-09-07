<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\HasEnumOptions;

enum ServiceType: string
{
    use HasEnumOptions;

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
}
