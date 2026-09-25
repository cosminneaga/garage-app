<?php

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum WorkorderOperationTimeColumns: string
{
    use HasEnumOptions;

    case START = 'start';
    case END = 'end';
}
