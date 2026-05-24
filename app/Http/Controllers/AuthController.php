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
        if (! Auth::attempt($request->safe()->all())) {
            return redirect()
                ->back()
                ->with('message', self::responseMessage(
                    'error',
                    'Authentication failed',
                    'We were unable to authenticate using the provided credentials. Please verify your login details and try again.',
                ))
                ->withInput();
        }

        $user = User::where(['email' => $request->safe()->email])->first();

        if ($user && ! $user->active) {
            return redirect()
                ->back()
                ->with('message', self::responseMessage(
                    'error',
                    'Your account has been suspended',
                    'Please contact administration to resolve the issue and restore access.',
                ));
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with('message', self::responseMessage(
                'success',
                'Login successful',
                'You are logged in and can now access your account.',
            ));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
