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
        return view('pages.profile.edit', [
            'user' => Auth::user(),
            'countries' => Country::all(),
        ]);
    }

    public function update(UpdateProfileRequest $request, User $user, UserUpdateAction $action): RedirectResponse
    {
        $action->handle($request->validated(), $user);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Profile updated',
                'Your profile has been updated successfully',
            ));
    }
}
