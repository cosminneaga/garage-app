<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\UserPermission;
use Illuminate\Support\Facades\Auth;

class Permission
{
    public static function can(UserPermission $permission, string $action): bool
    {
        return Auth::check() && Auth::user()->can(UserPermission::name($permission, $action));
    }
}
