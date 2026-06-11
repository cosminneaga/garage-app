<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Supplier;
use App\Models\User;

interface SupplierPolicyInterface
{
    public function removeAddress(User $user, Supplier $supplier): bool;

    public function removeContact(User $user, Supplier $supplier): bool;
}
