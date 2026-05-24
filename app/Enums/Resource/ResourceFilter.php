<?php

namespace App\Enums\Resource;

enum ResourceFilter: string
{
    case DEFAULT = 'default';
    case WITH_TRASHED = 'with_trashed';
    case ONLY_TRASHED = 'only_trashed';
}
