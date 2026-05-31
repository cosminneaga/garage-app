<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CompanyStoreAction;
use App\Actions\CompanyUpdateAction;
use App\Enums\Resource\ResourceFilter;
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

    public function __construct(protected CompanyService $companyService, protected UserService $userService)
    {
        //
    }

    /**
     * Display all resources related to model
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Company::class);
        $querySearch = $request->string('search')->value();

        return view('pages.company.index', [
            'companies' => $this->companyService
                ->search($querySearch)
                ->filterOwn(ResourceFilter::DEFAULT)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Auth::user());

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

        return view('pages.company.edit', [
            'company' => $company,
            'countries' => Country::all(),
            'team' => $this->userService->filterOwnNotInCompany($company)->get(),
        ]);
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

        return redirect(route('companies.index'))
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
                ->filterOwn(ResourceFilter::ONLY_TRASHED)
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

    // ADMIN
    public function all(Request $request): View
    {
        $querySearch = $request->string('search')->value();

        return view('pages.company.admin', [
            'companies' => $this->companyService
                ->search($querySearch)
                ->filterAll(ResourceFilter::WITH_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }
}
