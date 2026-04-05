<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function all()
    {
        $this->authorize('viewAny');

        return view('pages.user.index', [
            'users' => User::all(),
        ]);
    }

    public function index()
    {
        $user = Auth::user();
        $this->authorize('view', $user);

        return view('pages.user.index', [
            'users' => $user->team()->get(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Auth::user());

        return view('pages.user.create');
    }

    public function store(StoreUserRequest $request)
    {
        dd($request->safe()->all());

        return back()->with('success', 'User created');
    }

    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        if ($user->id === Auth::user()->id) {
            return back()->with('error', 'Please update your own details from profile section');
        }

        return view('pages.user.update', [
            'user' => $user,
            'addresses' => $user->addresses()->get(),
            'contacts' => $user->contacts()->get(),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('edit', $user);

        if ($user->id === Auth::user()->id) {
            return back()->with('error', 'Please update your own details from profile section');
        }

        User::updateOrCreate(
            ['id' => $user->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'active' => $request->boolean('active'),
            ]
        );

        return back()->with('success', 'User updated');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === Auth::user()->id) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user = User::findOrFail($user->id);
        $user->delete();

        return redirect()->intended(route('users.index'))->with('warn', 'User removed');
    }
}
