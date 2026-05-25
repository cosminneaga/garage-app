<?php

declare(strict_types=1);

namespace App\Enums\Columns;

enum AddressColumns: string
{
    case ID = 'ID';
    case NUMBER = 'Number';
    case STREET = 'Street';
    case POSTCODE = 'Postcode';
    case EXTRA = 'Extra Info';
}
