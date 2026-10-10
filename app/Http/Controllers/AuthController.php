<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show(): View
    {
        return view('pages.auth.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->safe()->all())) {
            return redirect()
                ->back()
                ->with(self::flashMessage(
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
                ->with(self::flashMessage(
                    'error',
                    'Your account has been suspended',
                    'Please contact administration to resolve the issue and restore access.',
                ));
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'))
            ->with(self::flashMessage(
                'success',
                'Login successful',
                'You are logged in and can now access your account.',
            ));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }

    public function clientShow(): View
    {
        return view('pages.auth.client.login');
    }

    public function clientAuthenticate(LoginRequest $request): RedirectResponse
    {
        if (! Auth::guard('client')->attempt($request->safe()->all())) {
            return redirect()
                ->back()
                ->with(self::flashMessage(
                    'error',
                    'Authentication failed',
                    'We were unable to authenticate using the provided credentials. Please verify your login details and try again.',
                ))
                ->withInput();
        }

        $client = Client::whereEmail($request->safe()->email)->first();

        if ($client && ! $client->active) {
            return redirect()
                ->back()
                ->with(self::flashMessage(
                    'error',
                    'Your account has been suspended',
                    'Please contact administration to resolve the issue and restore access.',
                ));
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('clients.home'))
            ->with(self::flashMessage(
                'success',
                'Login successful',
                'You are logged in and can now access your account.',
            ));
    }

    public function clientLogout(Request $request): RedirectResponse
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('clients.login'));
    }
}
