<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\User;

class SupplierPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'show');
    }
    public function show(User $user, mixed $supplier): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'show') && $supplier->isMySupplier($user);
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'store');
    }

    public function update(User $user, mixed $supplier): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'update') && $supplier->isMySupplier($user);
    }

    public function destroy(User $user, mixed $supplier): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'delete') && $supplier->isMySupplier($user);
    }

    public function restore(User $user, mixed $supplier): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'restore') && $supplier->isMySupplier($user);
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'restore');
    }
}
