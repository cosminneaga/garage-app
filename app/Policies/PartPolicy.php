<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class PartPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::PART, 'show');
    }

    public function show(User $user, mixed $part): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::PART, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::PART, 'store');
    }

    public function update(User $user, mixed $part): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::PART, 'update');
    }

    public function destroy(User $user, mixed $part): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::PART, 'delete');
    }

    public function restore(User $user, mixed $part): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::PART, 'restore');
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::PART, 'restore');
    }
}
