<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\User;
use Exception;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder as ScoutBuilder;

class UserService
{
    public string $searchQuery = '';
    public ScoutBuilder|User|EloquentBuilder $result;

    public function __construct(
        #[CurrentUser]
        protected User $user,
    ) {
    }

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

        return $this;
    }

    /**
     * Filter user by given model.
     * Model users that are attached to the given model.
     *
     * @param Model $model
     * @return UserService
     */
    public function whereIn(Model $model): UserService
    {
        $this->result->whereIn('users.id', $model->users()->select('users.id'));

        return $this;
    }

    /**
     * Filter user by given model.
     * Model users that are not attached to the given model.
     *
     * @param Model $model
     * @return UserService
     */
    public function whereNotIn(Model $model): UserService
    {
        $this->result->whereNotIn('users.id', $model->users()->select('users.id'));

        return $this;
    }

    /**
     * Returns a list of related users based on authenticated or given user
     * able to select user account using administrator role, thus all users
     * must have a role assigned.
     *
     * Fetching the related users for manager or administrator.
     * $service->model()->team(UserRole::USER)->get();
     *
     * Applying search query on related users for manager or administrator.
     * $service->search('user')->team(UserRole::USER)->get();
     *
     * Applying resource filtering with pagination on related users for manager or administrator.
     * $service->search('user')->resourceFilter(ResourceFilter::ONLY_TRASHED)->team(UserRole::USER)->paginate();
     */
    public function team(UserRole $forRole): UserService
    {

        $role = $this->user->getRoleNames();

        if (count($role) === 0) {
            throw new Exception('Designated user must have a role attached');
        }

        if (UserRole::from($role[0]) === $forRole) {
            throw new Exception('A relation cannot be build on same roles');
        }

        $pointRole = UserRole::from($role[0]);
        $relationMapped = UserRole::mapRelation($pointRole, $forRole);

        $first = $relationMapped->first();
        $last = $relationMapped->last();
        $result = $this->user;

        /* ------------------------------- INNER JOINS ------------------------------ */
        /**
         * Legend ancronyms:
         * $jtn => joined table name
         * $jtc => joined table column
         * $ctn => current table name
         * $ctc -> current table column
         */
        if (count($relationMapped) > 2) {
            $result = $result->join(
                $last->table_name,
                $last->table_name . '.' . collect($last->columns)->getBy('type', 'pk')->value,
                '=',
                'users.id'
            );

            $inner = $relationMapped->slice(1, -1);
            foreach ($inner as $index => $ir) {
                $previous = $relationMapped[$index - 1];
                $next = $relationMapped[$index + 1];

                $jtn = $previous->table_name;
                $jtc = collect($previous->columns)->getBy('type', 'fk')->value;
                $ctn = $ir->table_name;
                $ctc = collect($ir->columns)->getBy('type', 'pk')->value;

                if ($ir->table_name === $previous->table_name) {
                    $ctn = $next->table_name;
                }

                $result = $result->join($jtn, $jtn . '.' . $jtc, '=', $ctn . '.' . $ctc);
            }

            $result = $result->where(
                $first->table_name . '.' . collect($first->columns)->getBy('type', 'pk')->value,
                $this->user->id
            );
        } else {
            $result = $result->join(
                $first->table_name,
                $first->table_name . '.' . $first->columns[1]->value,
                '=',
                'users.id'
            )->where(
                $first->table_name . '.' . $first->columns[0]->value,
                $this->user->id
            );
        }

        $result = $result->select('users.*')->distinct();

        /* ------------------ QUERY BUILDER & SCOUT SEARCH SWITCHER ----------------- */
        switch ($this->result::class) {
            case \Laravel\Scout\Builder::class:
                $this->result->whereIn('id', $result->select('users.id'));
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
        $this->result->dd();
    }
}
