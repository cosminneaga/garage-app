<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum VehicleColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case REGISTRATION = 'registration';
    case FUEL = 'fuel';
    case STATUS = 'status';
}
