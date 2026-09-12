<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class VehiclePolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::VEHICLE, 'show');
    }

    public function show(User $user, mixed $vehicle): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::VEHICLE, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::VEHICLE, 'store');
    }

    public function update(User $user, mixed $vehicle): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::VEHICLE, 'update');
    }

    public function destroy(User $user, mixed $vehicle): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::VEHICLE, 'delete');
    }

    public function restore(User $user, mixed $vehicle): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::VEHICLE, 'restore');
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::VEHICLE, 'restore');
    }
}
