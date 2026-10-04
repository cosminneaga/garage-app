<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function userImage(Request $request, User $user)
    {
        $path = Storage::disk('local')->path($user->image_path);
        abort_unless(file_exists($path), 404);

        return response()->file($path);
    }
}
