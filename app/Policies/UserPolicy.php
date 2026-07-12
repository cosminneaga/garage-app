<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Helpers\Permission;
use App\Models\User;

class UserPolicy
{
    public function viewAny(): bool
    {
        return Permission::can(UserPermission::USER, 'show');
    }

    public function view(User $user, User $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'show')) {
            return false;
        }

        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model)
        };
    }

    public function create(): bool
    {
        return Permission::can(UserPermission::USER, 'store');
    }

    public function edit(User $user, User $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'update')) {
            return false;
        }

        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model),
        };
    }

    public function delete(User $user, User $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'delete')) {
            return false;
        }

        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model)
        };
    }

    public function viewTrashed(): bool
    {
        return Permission::can(UserPermission::USER, 'restore');
    }

    public function restore(User $user, User $model): bool
    {
        if (!Permission::can(UserPermission::USER, 'restore')) {
            return false;
        }

        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)),
            UserRole::MANAGER->value => $user->isMyUser($model)
        };
    }
}
