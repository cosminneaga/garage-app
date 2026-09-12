<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum ClientColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case NAME = 'name';
    case EMAIL = 'email';
    case ACTIVE = 'active';
}
