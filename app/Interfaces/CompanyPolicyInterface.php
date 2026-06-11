<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Company;
use App\Models\User;

interface CompanyPolicyInterface
{
    public function removeAddress(User $user, Company $company): bool;

    public function removeContact(User $user, Company $company): bool;
}
