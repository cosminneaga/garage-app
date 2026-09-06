<?php

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

    public function show(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'store');
    }

    public function update(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'update');
    }

    public function destroy(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'destroy');
    }

    public function restore(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'restore');
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::WORKORDER_OPERATION, 'restore');
    }
}
