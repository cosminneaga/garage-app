<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;

class PermissionPolicy
{
    public function show(): bool
    {
        return Permission::can(UserPermission::PERMISSION, 'show');
    }

    public function assign(): bool
    {
        return Permission::can(UserPermission::PERMISSION, 'update');
    }

    public function revoke(): bool
    {
        return Permission::can(UserPermission::PERMISSION, 'delete');
    }
}
