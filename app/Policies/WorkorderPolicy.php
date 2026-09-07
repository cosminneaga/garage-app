<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class WorkorderPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'show');
    }

    public function show(User $user, mixed $workorder): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER, 'show') && $workorder->isPartOfMyCompany($user);
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'store');
    }

    public function update(User $user, mixed $workorder): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER, 'update') && $workorder->isMine($user);
    }

    public function destroy(User $user, mixed $workorder): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER, 'destroy') && $workorder->isMine($user);
    }

    public function restore(User $user, mixed $workorder): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER, 'restore') && $workorder->isMine($user);
    }

    public function showTrashed(): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER, 'restore');
    }
}
