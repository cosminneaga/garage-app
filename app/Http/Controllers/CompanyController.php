<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CompanyAddressStoreAction;
use App\Actions\CompanyContactStoreAction;
use App\Actions\CompanyStoreAction;
use App\Actions\CompanyUpdateAction;
use App\Http\Requests\StoreCompanyAddressRequest;
use App\Http\Requests\StoreCompanyContactRequest;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Address;
use App\Models\Company;
use App\Models\Contact;
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
            'companies' => Company::paginate($request->query('limit') ?? 10, ['*'], 'companies'),
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
                ->paginate(
                    $request->query('limit') ?? 10,
                ['companies.id', 'name', 'tax_id', 'registration_number', 'tax_value', 'invoice_prefix', 'image_path'],
                    'companies'
                ),
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
    public function store(StoreCompanyRequest $request, CompanyStoreAction $action)
    {
        $action->handle($request->safe()->all());

        return redirect(route('companies.index'))
            ->with('message', self::responseMessage(
                'success',
                'Company created',
                'The company has been successfully created and is now available in your account.'
            ));
    }

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
    public function update(UpdateCompanyRequest $request, Company $company, CompanyUpdateAction $action)
    {
        $action->handle($request->safe()->all(), $company);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Company updated',
                'The company details have been successfully updated.'
            ));
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
            ->with('message', self::responseMessage(
                'info',
                'Company removed',
                'The company has been successfully removed from your account.'
            ));
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
    public function restore(Company $company)
    {
        $company = Company::onlyTrashed()->find($company->id);
        $this->authorize('restore', $company);
        $company->restore();

        return redirect()
            ->intended(route('companies.removed'))
            ->with('message', self::responseMessage(
                'success',
                'Company restored',
                'The company has been successfully restored and is now available in your account.'
            ));
    }

    public function addAddress(StoreCompanyAddressRequest $request, Company $company, CompanyAddressStoreAction $action)
    {
        $action->handle($request->safe()->all(), $company);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Address created',
                'Company address has been created and attached'
            ));
    }

    public function removeAddress(Company $company, Address $address)
    {
        $this->authorize('removeAddress', $company);
        $company->addresses()->detach($address);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Address removed',
                'Company address has been removed'
            ));
    }

    public function addContact(StoreCompanyContactRequest $request, Company $company, CompanyContactStoreAction $action)
    {
        $action->handle($request->safe()->all(), $company);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Contact created',
                'Contact information has been created and attached'
            ));
    }

    public function removeContact(Company $company, Contact $contact)
    {
        $this->authorize('removeContact', $company);
        $company->contacts()->detach($contact);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Contact removed',
                'Contact information has been removed'
            ));
    }
}
