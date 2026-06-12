<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\User;
use Exception;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
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
     *
     * @return UserService
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
     * @return UserService
     */
    public function with(string|array $relations): UserService
    {
        $this->result = $this->result->with($relations);

        return $this;
    }

    /**
     * Select the related columns when querying a related collection.
     * Applies select query on $this->result;
     *
     * @param $relations - ['users.id', 'users.name']
     * @return UserService
     */
    public function select(string|array $relations): UserService
    {
        $this->result = $this->result->select($relations);

        return $this;
    }

    /**
     * Scout search, applies search on queried collections.
     * Applies search query builder on $this->result;
     *
     * @param string $search - search string
     * @return UserService
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
     * @return UserService
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

    // !!! Keeping this here to have an idea how data was manipulated, after re-work, erase
    // public function whereNotInCompany(Company $company): UserService
    // {
    //     $this->filterOwn(ResourceFilter::DEFAULT)->result->whereNotIn('id', $company->users()->select('users.id'));

    //     return $this;
    // }

    // public function whereInCompany(Company $company): UserService
    // {
    //     $this->result->whereIn('id', $company->users()->select('users.id'));

    //     return $this;
    // }

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
     *
     * @param UserRole $forRole
     * @return UserService
     */
    public function team(UserRole $forRole): UserService
    {

        $role = $this->user->getRoleNames();

        if (!count($role)) {
            throw new Exception('Designated user must have a role attached');
        }

        if (UserRole::from($role[0]) === $forRole) {
            throw new Exception('A relation cannot be build on same roles');
        }

        $pointRole = UserRole::from($role[0]);
        $relationMapped = UserRole::mapRelation($pointRole, $forRole);


        $first = $relationMapped->first();
        $last = $relationMapped->last();

        // extract the target
        $result = $this->user;
        $result = $result->join($last['table_name'], $last['table_name'] . '.' . $last['columns'][0], '=', 'users.id');

        // inner joins
        if (count($relationMapped) > 2) {
            $inner = $relationMapped->slice(1, -1);

            foreach ($inner as $index => $ir) {
                $previous = $relationMapped[$index - 1];
                $result = $result->join($previous['table_name'], $previous['table_name'] . '.' . $previous['columns'][1], '=', $ir['table_name'] . '.' . $ir['columns'][0]);
            }
        }

        $result = $result
            ->where($first['table_name'] . '.' . $first['columns'][0], $this->user->id)
            ->distinct();

        switch(get_class($this->result)) {
            case 'Laravel\Scout\Builder':
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
     *
     * @param mixed $columns
     * @return Collection
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
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit, array $query = []): LengthAwarePaginator
    {
        return $this->result->paginate($limit, 'users')->appends($query);
    }
}
