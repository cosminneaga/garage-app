<?php

declare(strict_types=1);

namespace App\Enums\Columns;

enum CompanyColumns: string
{
    case ID = 'ID';
    case NAME = 'Name';
    case TAX_ID = 'Tax ID';
    case REGISTRATION_NUMBER = 'Registration Number';
    case TAX_VALUE = 'Tax Value';
    case INVOICE_PREFIX = 'Invoice Prefix';
}
