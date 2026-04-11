<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use App\Services\UserService;
use App\Traits\ResponseMessage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use AuthorizesRequests, ResponseMessage;

    public function __construct(protected CompanyService $companyService, protected UserService $userService) {}

    /**
     * Display the admin listing of all resources in DB
     */
    public function all(Request $request)
    {
        return view('pages.company.index', [
            'companies' => Company::paginate($request->query('limit') ?? 10, ['*'], 'company'),
        ]);
    }

    /**
     * Display all resources related to model
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Company::class);
        return view('pages.company.index', [
            'companies' => $this->companyService
                ->getMyCompanies(Auth::user())
                ->paginate($request->query('limit') ?? 10),
        ]);
    }

    /**
     * Display a single resource
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return view('pages.company.show', [
            'company' => $company,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        return view('pages.company.create', [
            'addresses' => $this->userService
                ->getRelatedAddresses(Auth::user()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $this->companyService->createOne(
            $request->safe()->all(),
            Auth::user()->id,
        );

        return back()->with('message', self::responseMessage('success', 'Resource created'));
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $this->authorize('edit', $company);

        return view('pages.company.update', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        Company::updateOrCreate(['id' => $company->id], $request->safe()->all());

        return back()
            ->with('message', self::responseMessage('success', 'Resource updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company = Company::findOrFail($company->id);
        $company->delete();

        return redirect()
            ->intended(route('companies.index'))
            ->with('message', self::responseMessage('warning', 'Company removed'));
    }

    /**
     * Show the page with previously removed item
     */
    public function removed(Request $request)
    {
        $this->authorize('viewTrashed', Company::class);

        return view('pages.company.removed', [
            'companies' => Auth::user()
                ->companies()
                ->onlyTrashed()
                ->paginate($request->query('limit') ?? 10),
        ]);
    }

    /**
     * Restore a given item
     */
    public function restore(string|int $companyId)
    {
        $company = Company::onlyTrashed()->find($companyId);
        $this->authorize('restore', $company);
        $company->restore();

        return redirect()
            ->intended(route('companies.removed'))
            ->with('message', self::responseMessage('success', 'Company restored'));
    }
}
