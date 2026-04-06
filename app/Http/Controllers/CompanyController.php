<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Country;
use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected CompanyService $companyService,
        protected UserService $userService
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        $this->authorize('viewAny');

        return view('pages.company.index', [
            'companies' => Company::paginate($request->query('limit') ?? 10),
        ]);
    }

    public function index(Request $request)
    {
        return view('pages.company.index', [
            'companies' => Auth::user()->companies()->paginate($request->query('limit') ?? 10),
        ]);
    }

    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return view('pages.company.single', [
            'company' => $company,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.company.create', [
            'addresses' => $this->userService->getRelatedAddresses(Auth::user()),
            'countries' => Country::all(),
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

        return back()->with('success', 'Resource created');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('pages.company.update', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        Company::updateOrCreate(
            ['id' => $company->id],
            $request->safe()->all()
        );

        return back()->with('success', 'Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): void
    {
        //
    }
}
