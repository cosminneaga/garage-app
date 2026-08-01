<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;

class Permission
{
    public static function can(UserPermission $permission, string $action): bool
    {
        if (!Auth::check()) {
            return false;
        }

        if (Auth::user()->hasRole(UserRole::SUPER)) {
            return true;
        }

        return Auth::user()->can(UserPermission::name($permission, $action));
    }

    public static function value(UserPermission $permission, string $action): string
    {
        return UserPermission::name($permission, $action);
    }
}
