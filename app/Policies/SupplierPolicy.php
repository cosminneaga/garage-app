<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'show');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Supplier $supplier): bool
    {
        return $supplier->isMySupplier($user) && Permission::can(UserPermission::SUPPLIER, 'show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'store');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function edit(User $user, Supplier $supplier): bool
    {
        return $supplier->isMySupplier($user) && Permission::can(UserPermission::SUPPLIER, 'update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        return $supplier->isMySupplier($user) && Permission::can(UserPermission::SUPPLIER, 'delete');
    }

    /**
     * Has access to view the deleted resources
     */
    public function viewTrashed(): bool
    {
        return Permission::can(UserPermission::SUPPLIER, 'restore');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Supplier $supplier): bool
    {
        return $supplier->isMySupplier($user) && Permission::can(UserPermission::SUPPLIER, 'restore');
    }
}
