<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;

trait PermissionValidator
{
    public static function checkPermission(UserPermission $userPermission, string $action, User $user): bool
    {
        if (! $user->hasPermissionTo(UserPermission::name($userPermission, $action))) {
            throw new UnauthorizedException(403);
        }

        return true;
    }

    public static function checkRole(UserRole $userRole, User $user): bool
    {
        if (! $user->hasRole($userRole)) {
            throw new UnauthorizedException(403);
        }

        return true;
    }
}
