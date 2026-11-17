<?php

declare(strict_types=1);

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
