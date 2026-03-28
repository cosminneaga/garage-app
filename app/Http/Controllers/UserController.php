<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        if (! Auth::attempt($attributes)) {
            return redirect()
                ->back()
                ->withErrors([
                    'password' => 'We were unable to authenticate using the provided credentials.',
                ])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with('success', 'You are logged in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
