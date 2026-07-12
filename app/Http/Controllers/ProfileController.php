<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserUpdateAction;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Country;
use App\Models\User;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ResponseMessage;

    public function edit(): View
    {
        return match(request()->query('tab')) {
            'statistics' => view('pages.profile.edit.statistics', ['user' => Auth::user()]),
            'contacts' => view('pages.profile.edit.contacts', ['user' => Auth::user()]),
            'addresses' => view('pages.profile.edit.addresses', [
                'user' => Auth::user(),
                'countries' => Country::all(),
            ]),
            'settings' => view('pages.profile.edit.settings', ['user' => Auth::user()]),
            default => view('pages.profile.edit.index', ['user' => Auth::user()]),
        };
    }

    public function update(UpdateProfileRequest $request, User $user, UserUpdateAction $action): RedirectResponse
    {
        $action->handle($request->validated(), $user);

        return back()
            ->with(self::flashMessage(
                'success',
                'Profile updated',
                'Your profile has been updated successfully',
            ));
    }
}
