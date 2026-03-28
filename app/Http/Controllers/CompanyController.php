<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAll()
    {
        $this->authorize('viewAny');

        return view('pages.company.index', [
            'companies' => Company::all(),
        ]);
    }

    public function showOwn(Request $request)
    {
        $user = Auth::user();

        return view('pages.company.index', [
            'companies' => $user->companies,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
