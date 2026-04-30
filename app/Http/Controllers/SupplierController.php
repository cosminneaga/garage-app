<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use ResponseMessage;

    public function __construct()
    {
        //
    }

    /**
     * Display the admin listing of all resources in DB
     */
    public function all(Request $request): View
    {
        return view('pages.supplier.index', [
            'suppliers' => Supplier::paginate($request->query('limit') ?? 10, ['*'], 'suppliers'),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        // $this->authorize('viewAny', Supplier::class);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier): void
    {
        //
    }
}
