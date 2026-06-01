<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\User;

class UserPolicy
{
    public function viewAny(): bool
    {
        return Permission::can(UserPermission::USER, 'show');
    }

    /**
     * Has access to user listing page
     */
    public function view(User $user, User $model): bool
    {
        return $user->isTeamMember($model) && Permission::can(UserPermission::USER, 'show');
    }

    /**
     * Has access to store page
     */
    public function create(): bool
    {
        return Permission::can(UserPermission::USER, 'store');
    }

    /**
     * Has access to update page
     */
    public function edit(User $user, User $model): bool
    {
        return $user->isTeamMember($model) && Permission::can(UserPermission::USER, 'update');
    }

    /**
     * Has access to delete the resource
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isTeamMember($model) && Permission::can(UserPermission::USER, 'delete');
    }

    /**
     * Has access to view the deleted resources
     */
    public function viewTrashed(): bool
    {
        return Permission::can(UserPermission::USER, 'restore');
    }

    /**
     * Has access to restore a deleted resource
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isTeamMember($model) && Permission::can(UserPermission::USER, 'restore');
    }
}
