<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\User;

class UserPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::USER, 'show');
    }

    public function show(User $user, mixed $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'show')) {
            return false;
        }

        return match ($user->getRoleNames()->first()) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model),
            default => $user->isMyUser($model),
        };
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::USER, 'store');
    }

    public function update(User $user, mixed $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'update')) {
            return false;
        }

        return match ($user->getRoleNames()->first()) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model),
            default => $user->isMyUser($model),
        };
    }

    public function destroy(User $user, mixed $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'delete')) {
            return false;
        }

        return match ($user->getRoleNames()->first()) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model),
            default => $user->isMyUser($model),
        };
    }

    public function restore(User $user, mixed $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'restore')) {
            return false;
        }

        return match ($user->getRoleNames()->first()) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model),
            default => $user->isMyUser($model),
        };
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::USER, 'restore');
    }
}
