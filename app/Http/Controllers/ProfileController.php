<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserUpdateAction;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Country;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return match(request()->query('tab')) {
            'statistics' => view('pages.user.profile.statistics', ['user' => Auth::user()]),
            'contacts' => view('pages.user.profile.contacts', ['user' => Auth::user()]),
            'addresses' => view('pages.user.profile.addresses', [
                'user' => Auth::user(),
                'countries' => Country::all(),
            ]),
            'settings' => view('pages.user.profile.settings', ['user' => Auth::user()]),
            default => view('pages.user.profile.index', ['user' => Auth::user()]),
        };
    }

    public function update(
        UpdateProfileRequest $request,
        UserUpdateAction $action
    ): RedirectResponse {
        $action->handle($request->safe()->all(), Auth::user());

        return back()
            ->with(self::flashMessage(
                'success',
                'Profile updated',
                'Your profile has been updated successfully',
            ));
    }
}
