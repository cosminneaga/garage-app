<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CompanyService
{
    public $searchQuery = '';

    public $result;

    public function __construct(
        #[CurrentUser]
        protected User $user,
    ) {
    }

    public function search(string $search): CompanyService
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

    public function get(mixed $columns = '*'): Collection
    {
        return $this->result->get($columns);
    }

    public function paginate(int $limit): LengthAwarePaginator
    {
        return $this->result->paginate($limit, 'companies')->appends(['search' => $this->searchQuery, 'limit' => $limit]);
    }
}
