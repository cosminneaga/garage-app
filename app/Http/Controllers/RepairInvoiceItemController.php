<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepairInvoiceItemRequest;
use App\Http\Requests\UpdateRepairInvoiceItemRequest;
use App\Models\RepairInvoiceItem;

class RepairInvoiceItemController extends Controller
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
    public function store(StoreRepairInvoiceItemRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairInvoiceItem $repairInvoiceItem): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairInvoiceItem $repairInvoiceItem): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairInvoiceItemRequest $request, RepairInvoiceItem $repairInvoiceItem): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairInvoiceItem $repairInvoiceItem): void
    {
        //
    }
}
