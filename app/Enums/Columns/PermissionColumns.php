<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum PermissionColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case NAME = 'name';
    case GUARD_NAME = 'guard_name';
}
