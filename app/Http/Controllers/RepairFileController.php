<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepairFileRequest;
use App\Http\Requests\UpdateRepairFileRequest;
use App\Models\RepairFile;

class RepairFileController extends Controller
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
    public function store(StoreRepairFileRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairFile $repairFile): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairFile $repairFile): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairFileRequest $request, RepairFile $repairFile): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairFile $repairFile): void
    {
        //
    }
}
