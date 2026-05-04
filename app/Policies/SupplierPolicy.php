<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Interfaces\SupplierPolicyInterface;
use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy implements SupplierPolicyInterface
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::name(UserPermission::SUPPLIER, 'show'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Supplier $supplier): bool
    {
        $supplier->isMySupplier($user);

        return $user->can(UserPermission::name(UserPermission::SUPPLIER, 'show'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::name(UserPermission::SUPPLIER, 'store'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Supplier $supplier): bool
    {
        return $supplier->isMySupplier($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        $supplier->isMySupplier($user);

        return $user->can(UserPermission::name(UserPermission::SUPPLIER, 'delete'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Supplier $supplier): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Supplier $supplier): bool
    {
        return false;
    }

    public function removeAddress(User $user, Supplier $supplier): bool
    {
        $supplier->isMySupplier($user);

        return $user->can(UserPermission::name(UserPermission::ADDRESS, 'delete'));
    }

    public function removeContact(User $user, Supplier $supplier): bool
    {
        $supplier->isMySupplier($user);

        return $user->can(UserPermission::name(UserPermission::CONTACT, 'delete'));
    }
}
