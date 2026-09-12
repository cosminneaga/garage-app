<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum ActionColumn: string
{
    use HasEnumOptions;

    case ACTION = 'action';
}
