<?php

namespace App\Enums\Related;

enum RelationNameUser: string
{
    case CEO = 'ceo';
    case ADMINISTRATOR = 'administrator';
    case MANAGER = 'manager';
    case USER = 'user';
}
