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

class CompanyService
{
    public $searchQuery = '';

    public Builder|Company|EloquentBuilder $result;

    public function __construct(
        #[CurrentUser]
        protected User $user,
    ) {
    }

    public function model(): CompanyService
    {
        $this->result = Company::query();

        return $this;
    }

    public function with(string|array $relations): CompanyService
    {
        $this->result = $this->result->with($relations);

        return $this;
    }

    public function select(string|array $relations): CompanyService
    {
        $this->result = $this->result->select($relations);

        return $this;
    }

    public function search(string $search = ''): CompanyService
    {
        $this->result = Company::search($search);
        $this->searchQuery = $search;

        return $this;
    }

    public function filterOwn(ResourceFilter $filter): CompanyService
    {
        if ($this->user->hasRole(UserRole::USER_EDITOR)) {
            $this->user = $this->user->managers()->first();
        }

        /**User::query()
            ->join('teams', 'users.id', '=', 'teams.user_id')
            ->where('teams.manager_id', 1)
            ->whereNull('users.deleted_at')
            ->select('users.*')
            ->distinct()
            ->orderByDesc('users.id')
            ->paginate(15);
        */

        // COUNT QUERY
        /**SELECT COUNT(DISTINCT users.id)
            FROM users
            INNER JOIN teams ON users.id = teams.user_id
            WHERE teams.manager_id = 1
            AND users.deleted_at IS NULL
        */

        // MAIN QUERY
        /**SELECT DISTINCT users.*
            FROM users
            INNER JOIN teams ON users.id = teams.user_id
            WHERE teams.manager_id = 1
            AND users.deleted_at IS NULL
            ORDER BY users.id DESC
            LIMIT 15 OFFSET 0
        */

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

    public function filterAll(ResourceFilter $filter): CompanyService
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

    public function paginate(int $limit): LengthAwarePaginator
    {
        return $this->result->paginate($limit, 'companies')->appends(['search' => $this->searchQuery, 'limit' => $limit]);
    }

    public function get(mixed $columns = '*'): Collection
    {
        return $this->result->get($columns);
    }
}
