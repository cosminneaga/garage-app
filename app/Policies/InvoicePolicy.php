<?php

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class InvoicePolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::INVOICE, 'show');
    }

    public function show(User $user, mixed $invoice): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::INVOICE, 'show') && $invoice->isPartOfMyCompany($user);
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::INVOICE, 'store');
    }

    public function update(User $user, mixed $invoice): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::INVOICE, 'update') && !$invoice->isLocked() && $invoice->isPartOfMyCompany($user);
    }

    public function destroy(User $user, mixed $invoice): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::INVOICE, 'destroy') && $invoice->isPartOfMyCompany($user);
    }

    public function restore(User $user, mixed $invoice): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::INVOICE, 'restore') && $invoice->isPartOfMyCompany($user);
    }

    public function showTrashed(): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::INVOICE, 'restore');
    }
}
