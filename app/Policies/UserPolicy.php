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
        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)) && Permission::can(UserPermission::USER, 'show'),
            UserRole::MANAGER->value => $user->isMyUser($model) && Permission::can(UserPermission::USER, 'show')
        };
    }

    public function create(): bool
    {
        return Permission::can(UserPermission::USER, 'store');
    }

    public function edit(User $user, User $model): bool
    {
        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)) && Permission::can(UserPermission::USER, 'update'),
            UserRole::MANAGER->value => $user->isMyUser($model) && Permission::can(UserPermission::USER, 'update')
        };
    }

    public function delete(User $user, User $model): bool
    {
        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)) && Permission::can(UserPermission::USER, 'delete'),
            UserRole::MANAGER->value => $user->isMyUser($model) && Permission::can(UserPermission::USER, 'delete')
        };
    }

    public function viewTrashed(): bool
    {
        return Permission::can(UserPermission::USER, 'restore');
    }

    public function restore(User $user, User $model): bool
    {
        return match ($user->getRoleNames()[0]) {
            UserRole::ADMINISTRATOR->value => ($user->isMyManager($model) || $user->isMyUser($model)) && Permission::can(UserPermission::USER, 'restore'),
            UserRole::MANAGER->value => $user->isMyUser($model) && Permission::can(UserPermission::USER, 'restore')
        };
    }
}
