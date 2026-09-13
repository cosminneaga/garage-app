<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum AddressColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case STREET_NUMBER = 'street_number';
    case STREET = 'street';
    case POSTCODE = 'postcode';
    case BUILDING = 'building';
    case FLOOR = 'floor';
    case UNIT = 'unit';
}
