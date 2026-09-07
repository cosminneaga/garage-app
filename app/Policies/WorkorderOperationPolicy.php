<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class WorkorderOperationPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'show');
    }

    public function show(User $user, mixed $workorder_operation): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION, 'show') && $workorder_operation->isPartOfMyCompany($user);
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'store');
    }

    public function update(User $user, mixed $workorder_operation): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION, 'update') && $workorder_operation->isMine($user);
    }

    public function destroy(User $user, mixed $workorder_operation): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION, 'destroy') && $workorder_operation->isMine($user);
    }

    public function restore(User $user, mixed $workorder_operation): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION, 'restore') && $workorder_operation->isMine($user);
    }

    public function showTrashed(): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION, 'restore');
    }
}
