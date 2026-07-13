<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\User;

class CompanyPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'show');
    }
    public function show(User $user, mixed $company): bool
    {
        return Permission::can(UserPermission::COMPANY, 'show') && $company->isMyCompany($user);
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'store');
    }

    public function update(User $user, mixed $company): bool
    {
        return Permission::can(UserPermission::COMPANY, 'update') && $company->isMyCompany($user);
    }

    public function destroy(User $user, mixed $company): bool
    {
        return Permission::can(UserPermission::COMPANY, 'delete') && $company->isMyCompany($user);
    }

    public function restore(User $user, mixed $company): bool
    {
        return Permission::can(UserPermission::COMPANY, 'restore') && $company->isMyCompany($user);
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'restore');
    }
}
