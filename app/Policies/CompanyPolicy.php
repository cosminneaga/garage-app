<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Has access to all resources page
     */
    public function viewAny(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'show');
    }

    /**
     * Has access to resource listing page
     */
    public function view(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'show');
    }

    /**
     * Has access to store page
     */
    public function create(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'store');
    }

    /**
     * Has access to update page
     */
    public function edit(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'update');
    }

    /**
     * Has access to delete the resource
     */
    public function delete(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'delete');
    }

    /**
     * Has access to view the deleted resources
     */
    public function viewTrashed(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'restore');
    }

    /**
     * Has access to restore a deleted resource
     */
    public function restore(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'restore');
    }
}
