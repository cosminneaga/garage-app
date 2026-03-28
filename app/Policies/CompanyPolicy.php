<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        $user = Auth::user();
        if ($user->hasRole(UserRole::ADMIN_SUPER->value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        if (! $company->users()->find($user->id)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Company $company): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Company $company): bool
    {
        return false;
    }
}
