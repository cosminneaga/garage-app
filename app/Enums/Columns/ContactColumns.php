<?php

declare(strict_types=1);

namespace App\Enums\Columns;

enum ContactColumns: string
{
    case ID = 'ID';
    case MOBILE = 'Mobile';
    case LANDLINE = 'Landline';
    case EMAIL = 'E-Mail';
    case URL = 'Url';
    case INFO = 'Extra Info';
}
