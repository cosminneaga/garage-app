<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Related\RelationNameUser;
use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder as ScoutBuilder;
use Throwable;

class UserService
{
    public $searchQuery = '';
    public ScoutBuilder|User|EloquentBuilder $result;

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

    public function resourceFilter(ResourceFilter $filter): UserService
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

    public function get(mixed $columns = '*'): Collection
    {
        return $this->result->get($columns);
    }

    public function paginate(int $limit, array $query = []): LengthAwarePaginator
    {
        return $this->result->paginate($limit, 'users')->appends($query);
    }

    /**
     * Returns a list of related users based on authenticated or given user
     * able to select user account using administrator role, thus all users
     * must have a role assigned.
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
}
