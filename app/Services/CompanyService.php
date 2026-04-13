<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CompanyService
{
    public function __construct()
    {
        //
    }

    public function getMyCompanies(User $user): BelongsToMany
    {
        if ($user->hasRole(UserRole::USER_EDITOR)) {
            $manager = $user->managers()->first();

            return $manager->companies();
        }

        return $user->companies();
    }
}
