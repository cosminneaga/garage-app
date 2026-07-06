<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function update(Permission $permission, User $user)
    {
        dd($permission->getAttributes(), $user->getAttributes());
    }

    public function destroy(Permission $permission, User $user)
    {
        dd($permission->getAttributes(), $user->getAttributes());
    }
}
