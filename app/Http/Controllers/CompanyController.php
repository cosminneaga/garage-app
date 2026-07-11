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
use App\Traits\RequestTabHandler;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use AuthorizesRequests;
    use RequestTabHandler;
    use ResponseMessage;

    public function __construct(
        protected CompanyService $companyService,
        protected UserService $userService
    ) {
    }

    /**
     * Display all resources related to model
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Company::class);
        $search = $request->string('search')->value();

        return view('pages.company.index', [
            'companies' => $this->companyService
                ->search($search)
                ->resourceFilterOwn(ResourceFilter::DEFAULT)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Company::class);

        return view('pages.company.create', [
            'countries' => Country::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request, CompanyStoreAction $action): RedirectResponse
    {
        $action->handle($request->safe()->all());

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Company created',
                'The company has been successfully created and is now available in your account.',
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company): View
    {
        $this->authorize('edit', $company);
        $search = request()->string('search')->value();

        $role = Auth::user()->getRoleNames();
        $forRole = $role[0] === UserRole::ADMINISTRATOR->value ? UserRole::MANAGER : ($role[0] === UserRole::USER->value ? UserRole::MANAGER : UserRole::USER);

        return match(request()->query('tab')) {
            'statistics' => view('pages.company.edit.statistics'),
            'members' => view('pages.company.edit.members', [
                'company' => $company,
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
                'company' => $company,
            ]),
            'addresses' => view('pages.company.edit.addresses', [
                'company' => $company,
                'countries' => Country::all(),
            ]),
            'suppliers' => view('pages.company.edit.suppliers', [
                'company' => $company,
                'countries' => Country::all(),
            ]),
            default => view('pages.company.edit.index', [
                'company' => $company,
            ]),
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company, CompanyUpdateAction $action): RedirectResponse
    {
        $action->handle($request->safe()->all(), $company);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Company updated',
                'The company details have been successfully updated.',
            ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);

        $company = Company::findOrFail($company->id);
        $company->delete();

        if (Auth::user()->isSuper()) {
            return redirect()
                ->intended(route('super.companies.all'))
                ->with('message', self::responseMessage(
                    'info',
                    'User removed',
                    'The company ' . $company->name . ' has been successfully removed.',
                ));
        }

        return redirect()
            ->intended(route('companies.index'))
            ->with('message', self::responseMessage(
                'info',
                'Company removed',
                'The company has been successfully removed from your account.',
            ));
    }

    /**
     * Show the page with previously removed item
     */
    public function removed(Request $request): View
    {
        $this->authorize('viewTrashed', Company::class);
        $querySearch = $request->string('search')->value();

        return view('pages.company.removed', [
            'companies' => $this->companyService
                ->search($querySearch)
                ->resourceFilterOwn(ResourceFilter::ONLY_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    /**
     * Restore a given item
     */
    public function restore(string|int $id): RedirectResponse
    {
        $company = Company::onlyTrashed()->find($id);
        $this->authorize('restore', $company);
        $company->restore();

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Company restored',
                'The company has been successfully restored and is now available in your account.',
            ));
    }
}
