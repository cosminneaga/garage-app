<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    use AuthorizesRequests;
    // public static function middleware(): array
    // {
    //     return [
    //         function (Request $request, Closure $next) {
    //             dump('company controller middleware');
    //             return $next($request);
    //         }
    //     ];
    // }

    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $this->authorize('viewAll');

        return view('pages.company.index', [
            'companies' => Company::all(),
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        return view('pages.company.index', [
            'companies' => $user->companies,
        ]);
    }

    public function show(Company $company)
    {
        $this->authorize('view', $company);
        // dd('reached');
        // $this->authorize('view', Company::class);

        return view('pages.company.single', [
            'company' => $company,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        Company::create($request->safe()->all());
        return back()->with('success', 'Resource created');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): void
    {
        //
    }
}
