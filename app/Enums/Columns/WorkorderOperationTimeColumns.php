<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum WorkorderOperationTimeColumns: string
{
    use HasEnumOptions;

    case START = 'start';
    case END = 'end';
}
