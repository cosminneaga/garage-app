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
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'store');
    }

    public function update(User $user, mixed $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'update');
    }

    public function destroy(User $user, mixed $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'delete');
    }

    public function restore(User $user, mixed $company): bool
    {
        return $company->isMyCompany($user) && Permission::can(UserPermission::COMPANY, 'restore');
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::COMPANY, 'restore');
    }
}
