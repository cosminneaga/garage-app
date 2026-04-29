<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermission::name(UserPermission::USER, 'show'));
    }

    /**
     * Has access to user listing page
     */
    public function view(User $user, User $model): bool
    {
        $user->isTeamMember($model);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::USER, 'show'));
    }

    /**
     * Has access to store page
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermission::name(UserPermission::USER, 'store'));
    }

    /**
     * Has access to update page
     */
    public function edit(User $user, User $model): bool
    {
        $user->isTeamMember($model);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::USER, 'update'));
    }

    /**
     * Has access to delete the resource
     */
    public function delete(User $user, User $model): bool
    {
        $user->isTeamMember($model);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::USER, 'delete'));
    }

    /**
     * Has access to view the deleted resources
     */
    public function viewTrashed(User $user): bool
    {
        return $user->hasPermissionTo(UserPermission::name(UserPermission::USER, 'restore'));
    }

    /**
     * Has access to restore a deleted resource
     */
    public function restore(User $user, User $model): bool
    {
        $user->isTeamMember($model);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::USER, 'restore'));
    }

    /**
     * Enabled only for 'super' role
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function removeAddress(User $user, User $model): bool
    {
        $user->isTeamMember($model);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::ADDRESS, 'delete'));
    }

    public function removeContact(User $user, User $model): bool
    {
        $user->isTeamMember($model);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::CONTACT, 'delete'));
    }
}
