<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum WorkorderColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case TITLE = 'title';
    case NUMBER = 'number';
    case STATUS = 'status';
}
