<?php

namespace App\Enums\Columns;

enum PermissionColumns: string
{
    case ID = 'ID';
    case NAME = 'Name';
    case GUARD_NAME = 'Guard Name';
    case ACTIONS = 'Actions';
}
