<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class WorkorderOperationLabourTimePolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'show');
    }

    public function show(User $user, mixed $address): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'store');
    }

    public function update(User $user, mixed $address): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'update');
    }

    public function destroy(User $user, mixed $address): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'destroy');
    }

    public function restore(User $user, mixed $address): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'restore');
    }

    public function showTrashed(): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'restore');
    }
}
