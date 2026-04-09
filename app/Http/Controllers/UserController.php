<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ResponseMessage;

    public function __construct(protected UserService $userService)
    {
        //
    }

    public function all(Request $request)
    {
        $this->authorize('viewAny');

        return view('pages.user.index', [
            'users' => User::paginate($request->query('limit') ?? 10),
        ]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $this->authorize('view', $user);

        return view('pages.user.index', [
            'users' => $user->team()->paginate($request->query('limit') ?? 10),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Auth::user());

        return view('pages.user.create');
    }

    public function store(StoreUserRequest $request)
    {
        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $this->userService->createOne($attributes, Auth::user());

        return back()->with('message', self::responseMessage('success', 'User created'));
    }

    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        if ($user->id === Auth::user()->id) {
            return back()->with('message', self::responseMessage('error', 'Please update your own details from profile section'));
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
            return back()->with('message', self::responseMessage('error', 'Please update your own details from profile section'));
        }

        User::updateOrCreate(
            ['id' => $user->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'active' => $request->boolean('active'),
            ]
        );

        return back()->with('message', self::responseMessage('success', 'User updated'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === Auth::user()->id) {
            return back()->with('message', self::responseMessage('error', 'You cannot delete your own account'));
        }

        $user = User::findOrFail($user->id);
        $user->delete();

        return redirect()
            ->intended(route('users.index'))
            ->with('message', self::responseMessage('warning', 'User removed'));
    }
}
