<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Interfaces\CompanyPolicyInterface;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy implements CompanyPolicyInterface
{
    /**
     * Has access to all resources page
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));
    }

    /**
     * Has access to resource listing page
     */
    public function view(User $user, Company $company): bool
    {
        if ($user->hasRole(UserRole::SUPER)) {
            return true;
        }

        $company->isMyCompany($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'show'));
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
    public function edit(User $user, Company $company): bool
    {
        if ($user->hasRole(UserRole::SUPER)) {
            return true;
        }

        $company->isMyCompany($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'update'));
    }

    /**
     * Has access to delete the resource
     */
    public function delete(User $user, Company $company): bool
    {
        if ($user->hasRole(UserRole::SUPER)) {
            return true;
        }

        $company->isMyCompany($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'delete'));
    }

    /**
     * Has access to view the deleted resources
     */
    public function viewTrashed(User $user): bool
    {
        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'restore'));
    }

    /**
     * Has access to restore a deleted resource
     */
    public function restore(User $user, Company $company): bool
    {
        if ($user->hasRole(UserRole::SUPER)) {
            return true;
        }

        $company->isMyCompany($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::COMPANY, 'restore'));
    }

    /**
     * Enabled only for 'super' role
     */
    public function forceDelete(User $user, Company $company): bool
    {
        return false;
    }

    public function removeAddress(User $user, Company $company): bool
    {
        if ($user->hasRole(UserRole::SUPER)) {
            return true;
        }

        $company->isMyCompany($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::ADDRESS, 'delete'));
    }

    public function removeContact(User $user, Company $company): bool
    {
        if ($user->hasRole(UserRole::SUPER)) {
            return true;
        }

        $company->isMyCompany($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::CONTACT, 'delete'));
    }

    public function removeSupplier(User $user, Company $company): bool
    {
        if ($user->hasRole(UserRole::SUPER)) {
            return true;
        }

        $company->isMyCompany($user);

        return $user->hasPermissionTo(UserPermission::name(UserPermission::SUPPLIER, 'delete'));
    }
}
