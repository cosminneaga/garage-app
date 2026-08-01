<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CompanyStoreAction;
use App\Actions\CompanyUpdateAction;
use App\Enums\Resource\ResourceFilter;
use App\Enums\UserRole;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Country;
use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService,
        protected UserService $userService
    ) {
    }

    public function index(Request $request): View
    {
        $this->authorize('showAll', Company::class);
        $search = $request->string('search')->value();

        return view('pages.company.index', [
            'companies' => $this->companyService
                ->search($search)
                ->resourceFilterOwn(ResourceFilter::DEFAULT)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('store', Company::class);

        return view('pages.company.create', [
            'countries' => Country::all(),
        ]);
    }

    public function store(StoreCompanyRequest $request, CompanyStoreAction $action): RedirectResponse
    {
        $action->handle($request->safe()->all());

        return back()
            ->with(self::flashMessage(
                'success',
                'Company created',
                'The company has been successfully created and is now available in your account',
            ));
    }

    public function edit(Company $company): View
    {
        $this->authorize('show', $company);
        $search = request()->string('search')->value();

        $role = Auth::user()->getRoleNames()->first();
        $forRole = $role === UserRole::ADMINISTRATOR->value ? UserRole::MANAGER : ($role === UserRole::USER->value ? UserRole::MANAGER : UserRole::USER);

        return match(request()->query('tab')) {
            'statistics' => view('pages.company.edit.statistics'),
            'members' => view('pages.company.edit.members', [
                'resource' => $company,
                'countries' => Country::all(),
                'non_members' => $this->userService
                    ->model()
                    ->team($forRole)
                    ->whereNotIn($company)
                    ->get(),
                'members' => $this->userService
                    ->search($search)
                    ->team($forRole)
                    ->whereIn($company)
                    ->get(),
            ]),
            'contacts' => view('pages.company.edit.contacts', [
                'resource' => $company,
            ]),
            'addresses' => view('pages.company.edit.addresses', [
                'resource' => $company,
                'countries' => Country::all(),
            ]),
            'suppliers' => view('pages.company.edit.suppliers', [
                'resource' => $company,
                'countries' => Country::all(),
            ]),
            default => view('pages.company.edit.index', [
                'resource' => $company,
            ]),
        };
    }

    public function update(
        UpdateCompanyRequest $request,
        Company $company,
        CompanyUpdateAction $action
    ): RedirectResponse {
        $action->handle($request->safe()->all(), $company);

        return back()
            ->with(self::flashMessage(
                'success',
                'Company updated',
                'The company details have been successfully updated',
            ));
    }

    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('destroy', $company);

        $company = Company::findOrFail($company->id);
        $company->delete();

        if (Auth::user()->isSuper()) {
            return redirect()
                ->intended(route('super.companies.all'))
                ->with(self::flashMessage(
                    'info',
                    'Company removed',
                    'The company ' . $company->name . ' has been successfully removed',
                ));
        }

        return redirect()
            ->intended(route('companies.index'))
            ->with(self::flashMessage(
                'info',
                'Company removed',
                'The company has been successfully removed from your account',
            ));
    }

    public function restore(string|int $id): RedirectResponse
    {
        $company = Company::onlyTrashed()->find($id);
        $this->authorize('restore', $company);
        $company->restore();

        return back()
            ->with(self::flashMessage(
                'success',
                'Company restored',
                'The company has been successfully restored and is now available in your account',
            ));
    }

    public function removed(Request $request): View
    {
        $this->authorize('showTrashed', Company::class);
        $querySearch = $request->string('search')->value();

        return view('pages.company.removed', [
            'companies' => $this->companyService
                ->search($querySearch)
                ->resourceFilterOwn(ResourceFilter::ONLY_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }
}
