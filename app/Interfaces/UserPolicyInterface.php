<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\User;

interface UserPolicyInterface
{
    public function removeAddress(User $user, User $model): bool;

    public function removeContact(User $user, User $model): bool;
}
