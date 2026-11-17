<?php

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum TransactionColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case METHOD = 'method';
    case TYPE = 'type';
    case VALUE = 'value';
}
