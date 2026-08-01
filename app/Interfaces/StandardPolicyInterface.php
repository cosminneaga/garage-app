<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\User;

interface StandardPolicyInterface
{
    /**
     * Has access to view all resources
     */
    public function showAll(): bool;

    /**
     * Has access to view a resource
     */
    public function show(User $user, mixed $model): bool;

    /**
     * Has access to store the resource
     */
    public function store(): bool;

    /**
     * Has access to update a resource
     */
    public function update(User $user, mixed $model): bool;

    /**
     * Has access to delete a resource
     */
    public function destroy(User $user, mixed $model): bool;

    /**
     * Has access to restore a deleted resource
     */
    public function restore(User $user, mixed $model): bool;

    /**
     * Has access to view the deleted resource
     */
    public function showTrashed(): bool;
}
