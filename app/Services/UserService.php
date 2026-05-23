<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class UserService
{
    public function __construct(#[CurrentUser] protected User $user)
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

    public function getMyTeamMembers(User $user): BelongsToMany
    {
        if ($user->hasRole(UserRole::USER_EDITOR)) {
            $user = $user->managers()->first();
        }

        return $user->members();
    }

    public function searchMyTeamPaginate(string $search, int $limit): LengthAwarePaginator
    {

        if ($this->user->hasRole(UserRole::USER_EDITOR)) {
            $this->user = $this->user->managers()->first();
        }

        $members = Cache::remember(
            'user:' . $this->user->id . ':members:search:' . $search,
            Carbon::now()->addMinutes(1),
            function () {
                return $this->user->members()->pluck('users.id');
            }
        );

        return User::search($search)->whereIn('id', $members)->paginate($limit, 'page');
    }
}
