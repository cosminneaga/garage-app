<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder as ScoutBuilder;

class UserService
{
    public string $searchQuery = '';
    public Collection $selectedRoles;
    public ResourceFilter|null $resourceFilter = null;
    public ScoutBuilder|User|EloquentBuilder $result;

    public function __construct(
        #[CurrentUser]
        protected User $user,
    ) {}

    /**
     * Used when pagination is not needed.
     * $service->model()->all()->get();
     */
    public function model(): UserService
    {
        $this->result = User::query();

        return $this;
    }

    /**
     * Adds related collection to the query builder.
     * Applies with on $this->result;
     *
     * @param string|array $relations - 'managers'
     */
    public function with(string|array $relations): UserService
    {
        $this->result->with($relations);

        return $this;
    }

    /**
     * Select the related columns when querying a related collection.
     * Applies select query on $this->result;
     *
     * @param string|array $relations - ['users.id', 'users.name']
     */
    public function select(string|array $relations): UserService
    {
        $this->result->select($relations);

        return $this;
    }

    /**
     * Order by specific columns and direction
     */
    public function orderBy(string $column, string $direction = 'asc'): UserService
    {
        $this->result->orderBy($column, $direction);

        return $this;
    }

    /**
     * Scout search, applies search on queried collections.
     * Applies search query builder on $this->result;
     *
     * @param string $search - search string
     */
    public function search(string $search = ''): UserService
    {
        $this->result = User::search($search);
        $this->searchQuery = $search;

        return $this;
    }

    /**
     * Filters the resources based on given filter, such as: default, with_trashed, only_trashed.
     * Applies filtering on $this->result;
     *
     * @param ResourceFilter $filter - ResourceFilter::DEFAULT
     */
    public function resourceFilter(ResourceFilter $filter = ResourceFilter::DEFAULT): UserService
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

        $this->resourceFilter = $filter;

        return $this;
    }

    /**
     * Filter user by given model.
     * Model users that are attached to the given model.
     * Ensuring filtering based on role.
     *
     */
    public function whereIn(Model $model): UserService
    {
        $this->result->whereIn('users.id', $model
            ->users()
            ->whereHas(
                'roles',
                fn ($query) => $query->whereIn('name', [...$this->selectedRoles])
            )->select('users.id')
        );

        return $this;
    }

    /**
     * Filter user by given model.
     * Model users that are not attached to the given model.
     * Ensuring filtering based on role.
     *
     */
    public function whereNotIn(Model $model): UserService
    {
        $this->result->whereNotIn('users.id', $model
            ->users()
            ->whereHas(
                'roles',
                fn ($query) => $query->whereIn('name', [...$this->selectedRoles])
            )->select('users.id')
        );

        return $this;
    }

    /**
     * Returns a list of users based on given roles and trash filter
     * $service->model()->team([UserRole::MANAGER, UserRole::USER], ResourceFilter::WITH_TRASHED)
     */
    public function team(array $roles, ResourceFilter $filter = ResourceFilter::DEFAULT): UserService
    {
        $this->selectedRoles = Collection::make($roles)->map(fn(UserRole $role) => $role->value);
        $result = User::whereHas('roles', fn ($query) => $query->whereIn('name', [...$this->selectedRoles]));

        /* --------------------------- RESOURCE FILTERING --------------------------- */
        switch ($filter) {
            case ResourceFilter::ONLY_TRASHED:
                $result = $result->onlyTrashed();
                $this->result->onlyTrashed();
                break;
            case ResourceFilter::WITH_TRASHED:
                $result = $result->withTrashed();
                $this->result->withTrashed();
                break;
            default:
                break;
        }

        /* ------------------ QUERY BUILDER & SCOUT SEARCH SWITCHER ----------------- */
        switch($this->result::class) {
            case \Laravel\Scout\Builder::class:
                $this->result->whereIn('users.id', $result->select('users.id'));
                break;
            default:
                $this->result = $result;
                break;
        }

        return $this;
    }

    /**
     * Returns the collection formed by the query builder
     */
    public function get(mixed $columns = '*'): Collection
    {
        return $this->result->get($columns);
    }

    /**
     * Returns pagination collection
     *
     * @param int $limit - the number of displaying resources
     * @param array $query - the rest of url query to be appended
     */
    public function paginate(int $limit, array $query = []): LengthAwarePaginator
    {
        return $this->result->paginate($limit, 'users')->appends($query);
    }

    /**
     * Dump and Die the SQL query
     */
    public function dd(): void
    {
        $this->result->ddRawSql();
    }
}
