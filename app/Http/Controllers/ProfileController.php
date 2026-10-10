<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserUpdateAction;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = Auth::guard('web')->user() ?? Auth::guard('client')->user();

        if (get_class($user) === Client::class) {
            return match (request()->query('tab')) {
                'statistics' => view('pages.client.portal.profile.statistics', ['user' => $user]),
                'contacts' => view('pages.client.portal.profile.contacts', ['user' => $user]),
                'addresses' => view('pages.client.portal.profile.addresses', [
                    'user' => $user,
                    'countries' => Country::all(),
                ]),
                'settings' => view('pages.client.portal.profile.settings', ['user' => $user]),
                default => view('pages.client.portal.profile.index', ['user' => $user]),
            };
        }

        return match (request()->query('tab')) {
            'statistics' => view('pages.user.profile.statistics', ['user' => $user]),
            'contacts' => view('pages.user.profile.contacts', ['user' => $user]),
            'addresses' => view('pages.user.profile.addresses', [
                'user' => $user,
                'countries' => Country::all(),
            ]),
            'settings' => view('pages.user.profile.settings', ['user' => $user]),
            default => view('pages.user.profile.index', ['user' => $user]),
        };
    }

    public function update(
        UpdateProfileRequest $request,
        UserUpdateAction $action
    ): RedirectResponse {
        $user = Auth::guard('web')->user() ?? Auth::guard('client')->user();
        $action->handle($request->safe()->all(), $user);

        return back()
            ->with(self::flashMessage(
                'success',
                'Profile updated',
                'Your profile has been updated successfully',
            ));
    }
}
