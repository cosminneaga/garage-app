<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserService
{
    public $searchQuery = '';

    public $result;

    public function __construct(
        #[CurrentUser]
        protected User $user,
    ) {
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

    public function search(string $search): UserService
    {
        $this->result = User::search($search);
        $this->searchQuery = $search;

        return $this;
    }

    public function filterOwn(ResourceFilter $filter): UserService
    {
        if ($this->user->hasRole(UserRole::USER_EDITOR)) {
            $this->user = $this->user->managers()->first();
        }

        switch ($filter) {
            case ResourceFilter::ONLY_TRASHED:
                $this->result->onlyTrashed()->whereIn('id', $this->user->members()->onlyTrashed()->select('users.id'));
                break;

            case ResourceFilter::WITH_TRASHED:
                $this->result->withTrashed()->whereIn('id', $this->user->members()->withTrashed()->select('users.id'));
                break;

            default:
                $this->result->whereIn('id', $this->user->members()->select('users.id'));
                break;
        }

        return $this;
    }

    public function filterAll(ResourceFilter $filter): UserService
    {
        switch ($filter) {
            case ResourceFilter::ONLY_TRASHED:
                $this->result->onlyTrashed();
                break;

            case ResourceFilter::WITH_TRASHED:
                $this->result->withTrashed();
                break;

            default:
                break;
        }

        return $this;
    }

    public function get(mixed $columns = '*'): Collection
    {
        return $this->result->get($columns);
    }

    public function paginate(int $limit): LengthAwarePaginator
    {
        return $this->result->paginate($limit, 'users')->appends(['search' => $this->searchQuery, 'limit' => $limit]);
    }
}
