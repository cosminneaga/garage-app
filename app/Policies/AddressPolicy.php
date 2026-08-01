<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class AddressPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'show');
    }

    public function show(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'store');
    }

    public function update(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'update');
    }

    public function destroy(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'destroy');
    }

    public function restore(User $user, mixed $address): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'restore');
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::ADDRESS, 'restore');
    }
}
