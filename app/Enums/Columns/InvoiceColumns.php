<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum InvoiceColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case NUMBER = 'number';
    case STATUS = 'status';
    case AMOUNT_DUE = 'amount_due';
    case AMOUNT_PAID = 'amount_paid';
}
