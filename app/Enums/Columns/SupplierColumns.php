<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum SupplierColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case NAME = 'name';
    case CODE = 'code';
    case TYPE = 'type';
    case TAX_ID = 'tax_id';
    case REGISTRATION_NUMBER = 'registration_number';
}
