<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceItemRequest;
use App\Http\Requests\UpdateInvoiceItemRequest;
use App\Models\InvoiceItem;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
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
    public function store(StoreInvoiceItemRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceItem $invoiceItem): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceItem $invoiceItem): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceItemRequest $request, InvoiceItem $invoiceItem): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceItem $invoiceItem): void
    {
        //
    }
}
