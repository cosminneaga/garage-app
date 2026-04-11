<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Has access to resource listing page
     */
    public function view(User $user, Company $model): bool
    {
        $model->isCompanyImPartOf($user);

        return $user->can(UserPermission::name(UserPermission::COMPANY, 'show'));
    }

    /**
     * Has access to store page
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'store'));
    }

    /**
     * Has access to update page
     */
    public function edit(User $user, Company $model): bool
    {
        $model->isCompanyImPartOf($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'update'));
    }

    /**
     * Has access to delete the item
     */
    public function delete(User $user, Company $model): bool
    {
        $model->isCompanyImPartOf($user);

        return $user->can(UserPermission::name(UserPermission::COMPANY, 'delete'));
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
