<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'show');
    }

    public function view(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'show');
    }

    public function create(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'store');
    }

    public function edit(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'update');
    }

    public function delete(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'delete');
    }

    public function viewTrashed(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'restore');
    }

    public function restore(User $user, Company $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'restore');
    }
}
