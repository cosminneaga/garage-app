<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;

class ClientController extends Controller
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
    public function store(StoreClientRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): void
    {
        //
    }
}
