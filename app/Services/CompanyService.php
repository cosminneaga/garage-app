<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Resource\ResourceFilter;
use App\Models\Company;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder;

class CompanyService
{
    public $searchQuery = '';

    public Builder|Company|EloquentBuilder $result;

    public function __construct(
        #[CurrentUser]
        protected User $user,
    ) {
    }

    /**
     * Used when pagination is not needed.
     * $service->model()->all()->get();
     */
    public function model(): CompanyService
    {
        $this->result = Company::query();

        return $this;
    }

    /**
     * Adds related collection to the query builder.
     * Applies with on $this->result;
     *
     * @param string|array $relations - 'users'
     */
    public function with(string|array $relations): CompanyService
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
    public function select(string|array $relations): CompanyService
    {
        $this->result->select($relations);

        return $this;
    }

    /**
     * Order by specific columns and direction
     */
    public function orderBy(string $column, string $direction = 'asc'): CompanyService
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
    public function search(string $search = ''): CompanyService
    {
        $this->result = Company::search($search);
        $this->searchQuery = $search;

        return $this;
    }

    /**
     * Filters the resources based on given filter, such as: default, with_trashed, only_trashed.
     * Applies filtering on $this->result;
     *
     * @param ResourceFilter $filter - ResourceFilter::DEFAULT
     */
    public function resourceFilter(ResourceFilter $filter = ResourceFilter::DEFAULT): CompanyService
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
     * Filters the resources based on given filter, such as: default, with_trashed, only_trashed.
     * Applies filtering on $this->result;
     *
     * @param ResourceFilter $filter - ResourceFilter::DEFAULT
     */
    public function resourceFilterOwn(ResourceFilter $filter = ResourceFilter::DEFAULT): CompanyService
    {
        switch ($filter) {
            case ResourceFilter::ONLY_TRASHED:
                $this->result->onlyTrashed()->whereIn('id', $this->user->companies()->onlyTrashed()->select('companies.id'));
                break;

            case ResourceFilter::WITH_TRASHED:
                $this->result->withTrashed()->whereIn('id', $this->user->companies()->withTrashed()->select('companies.id'));
                break;

            default:
                $this->result->whereIn('id', $this->user->companies()->select('companies.id'));
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
