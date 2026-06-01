<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder;

class UserService
{
    public $searchQuery = '';
    public Builder|User|EloquentBuilder $result;

    public function __construct(
        #[CurrentUser]
        protected User $user,
    ) {
    }

    public function model(): UserService
    {
        $this->result = User::query();

        return $this;
    }

    public function with(string|array $relations): UserService
    {
        $this->result = $this->result->with($relations);

        return $this;
    }

    public function select(string|array $relations): UserService
    {
        $this->result = $this->result->select($relations);

        return $this;
    }

    public function search(string $search = ''): UserService
    {
        $this->result = User::search($search);
        $this->searchQuery = $search;

        return $this;
    }

    public function filterOwn(ResourceFilter $filter): UserService
    {
        if ($this->user->hasRole([UserRole::USER_EDITOR->value, UserRole::USER_VIEWER->value])) {
            $this->user = $this->user->managers()->first();
        }

        switch ($filter) {
            case ResourceFilter::ONLY_TRASHED:
                $this->result->onlyTrashed()->whereIn('id', $this->user->team()->onlyTrashed()->select('users.id'));
                break;

            case ResourceFilter::WITH_TRASHED:
                $this->result->withTrashed()->whereIn('id', $this->user->team()->withTrashed()->select('users.id'));
                break;

            default:
                $this->result->whereIn('id', $this->user->team()->select('users.id'));
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

    public function whereNotInCompany(Company $company): UserService
    {
        $this->filterOwn(ResourceFilter::DEFAULT)->result->whereNotIn('id', $company->users()->select('users.id'));

        return $this;
    }

    public function whereInCompany(Company $company): UserService
    {
        $this->result->whereIn('id', $company->users()->select('users.id'));

        return $this;
    }

    public function get(mixed $columns = '*'): Collection
    {
        return $this->result->get($columns);
    }

    public function paginate(int $limit, array $query = []): LengthAwarePaginator
    {
        return $this->result->paginate($limit, 'users')->appends($query);
    }
}
