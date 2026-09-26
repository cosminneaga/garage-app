<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum WorkorderOperationColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case TYPE = 'type';
    case PART_INSTALLED_ODOMETER = 'part_installed_odometer';
    case EXPECTED_LIFE_KM = 'expected_life_km';
    case EXPECTED_LIFE_MONTHS = 'expected_life_months';
}
