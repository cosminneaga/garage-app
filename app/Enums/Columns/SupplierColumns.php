<?php

declare(strict_types=1);

namespace App\Enums\Columns;

enum SupplierColumns: string
{
    case ID = 'ID';
    case NAME = 'Name';
    case CODE = 'Code';
    case TYPE = 'Type';
    case TAX_ID = 'Tax ID';
    case REGISTRATION_NUMBER = 'Registration Number';
}
