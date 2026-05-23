<?php

declare(strict_types=1);

namespace App\Enums\Columns;

enum UserColumns: string
{
    case ID = 'ID';
    case NAME = 'Name';
    case EMAIL = 'Email';
    case Active = 'Active';
}
