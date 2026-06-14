<?php

declare(strict_types=1);

namespace App\Enums\Related;

enum RelationNameUser: string
{
    case CEO = 'ceo';
    case ADMINISTRATOR = 'administrator';
    case MANAGER = 'manager';
    case USER = 'user';
}
