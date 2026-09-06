<?php

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

    public function show(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'store');
    }

    public function update(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'update');
    }

    public function destroy(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'destroy');
    }

    public function restore(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'restore');
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::WORKORDER, 'restore');
    }
}
