<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserPolicy
{
    /**
     * Has access to user listing page
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('user-show');
    }

    /**
     * Has access to store page
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('user-store');
    }

    /**
     * Has access to 'update page'/'updating user' if the $model is a member of its own team
     */
    public function edit(User $user, User $model): bool
    {
        if (! $user->isTeamMember($model)) {
            throw new UnauthorizedException(404);
        }

        return $user->hasPermissionTo('user-update');
    }

    /**
     * Has access to 'delete' request if the $model is a member of its own team
     */
    public function delete(User $user, User $model): bool
    {
        if (! $user->isTeamMember($model)) {
            throw new UnauthorizedException(403);
        }

        return $user->hasPermissionTo('user-delete');
    }

    /**
     * Enabled only for 'super' role
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Enabled only for 'super' role
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
