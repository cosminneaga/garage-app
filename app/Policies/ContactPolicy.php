<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Models\User;

class ContactPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::CONTACT, 'show');
    }

    public function show(User $user, mixed $contact): bool
    {
        return Permission::can(UserPermission::CONTACT, 'show');
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::CONTACT, 'store');
    }

    public function update(User $user, mixed $contact): bool
    {
        return Permission::can(UserPermission::CONTACT, 'update');
    }

    public function destroy(User $user, mixed $contact): bool
    {
        return Permission::can(UserPermission::CONTACT, 'destroy');
    }

    public function restore(User $user, mixed $contact): bool
    {
        return Permission::can(UserPermission::CONTACT, 'restore');
    }

    public function showTrashed(): bool
    {
        return Permission::can(UserPermission::CONTACT, 'restore');
    }
}
