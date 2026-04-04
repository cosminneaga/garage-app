<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyPolicy
{
    public function viewAll(): bool
    {
        return Auth::user()->can('company-show_all');
    }

    public function view(User $user, Company $company): bool
    {
        $company->users()->findOrFail(Auth::user()->id);

        return $user->can('company-show');
    }

    public function delete(User $user, Company $company): bool
    {
        $company->users()->findOrFail(Auth::user()->id);

        return $user->can('company-delete');
    }

    public function restore(User $user, Company $company): bool
    {
        $company->users()->findOrFail(Auth::user()->id);

        return $user->can('company-restore');
    }
}
