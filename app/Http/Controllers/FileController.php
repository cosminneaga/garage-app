<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;

class FileController extends Controller
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
    public function store(StoreFileRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file): void
    {
        //
    }
}
