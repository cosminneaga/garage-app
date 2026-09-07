<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Helpers\Permission;
use App\Interfaces\StandardPolicyInterface;
use App\Models\User;

class BookingPolicy implements StandardPolicyInterface
{
    public function showAll(): bool
    {
        return Permission::can(UserPermission::BOOKING, 'show');
    }

    public function show(User $user, mixed $booking): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::BOOKING, 'show') && $booking->isPartOfMyCompany($user);
    }

    public function store(): bool
    {
        return Permission::can(UserPermission::BOOKING, 'store');
    }

    public function update(User $user, mixed $booking): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::BOOKING, 'update') && $booking->isMine($user);
    }

    public function destroy(User $user, mixed $booking): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::BOOKING, 'delete') && $booking->isMine($user);
    }

    public function restore(User $user, mixed $booking): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::BOOKING, 'restore') && $booking->isMine($user);
    }

    public function showTrashed(): bool
    {
        Permission::isSuper();

        return Permission::can(UserPermission::BOOKING, 'restore');
    }
}
