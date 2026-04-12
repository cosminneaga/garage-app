<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseMessage;

    public function show()
    {
        return view('pages.auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $user = User::where(['email' => $request->safe()->email])->first();

        if (! $user->active) {
            return redirect()
                ->back()
                ->with('message', self::responseMessage('error', 'Your account has been suspended'));
        }

        if (! Auth::attempt($request->safe()->all())) {
            return redirect()
                ->back()
                ->with('message', self::responseMessage('error', 'We were unable to authenticate using the provided credentials'))
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with('message', self::responseMessage('success', 'You are logged in'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
