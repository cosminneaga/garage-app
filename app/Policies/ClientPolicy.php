<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class ClientPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::CLIENT, 'show');
    }

    public function show(User $user, mixed $company): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::CLIENT, 'show') && $company->isMyClient($user);
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::CLIENT, 'store');
    }

    public function update(User $user, mixed $company): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::CLIENT, 'update') && $company->isMyClient($user);
    }

    public function destroy(User $user, mixed $company): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::CLIENT, 'delete') && $company->isMyClient($user);
    }

    public function restore(User $user, mixed $company): bool
    {
        if ($user->isSuper()) {
            return true;
        }

        return Permission::can(UserPermission::CLIENT, 'restore') && $company->isMyClient($user);
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::CLIENT, 'restore');
    }
}
