<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserService
{
    public function __construct()
    {
        //
    }

    public function getRelatedAddresses(User $user): array
    {
        return [
            'user' => $user->addresses()->get(),
            'companies' => $user->companies()->get()->map(fn ($company) => [
                'name' => $company->name,
                'addresses' => $company->addresses()->get(),
            ]),
        ];
    }

    public function getMyTeamMembers(User $user): UnauthorizedException|BelongsToMany
    {
        if ($user->hasRole(UserRole::USER_VIEWER)) {
            throw new UnauthorizedException(403);
        }

        if ($user->hasRole(UserRole::USER_EDITOR)) {
            $manager = $user->managers()->first();

            return $manager->members();
        }

        return $user->members();
    }
}
