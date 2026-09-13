<?php

declare(strict_types=1);

namespace App\Enums\Columns;

use App\Traits\HasEnumOptions;

enum ContactColumns: string
{
    use HasEnumOptions;

    case ID = 'id';
    case MOBILE = 'mobile';
    case LANDLINE = 'landline';
    case EMAIL = 'email';
    case URL = 'url';
    case INFO = 'info';
}
