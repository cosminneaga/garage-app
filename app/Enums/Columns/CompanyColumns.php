<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum CompanyColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case NAME = 'name';
    case TAX_ID = 'tax_id';
    case REGISTRATION_NUMBER = 'registration_number';
    case TAX_VALUE = 'tax_value';
    case INVOICE_PREFIX = 'invoice_prefix';
}
