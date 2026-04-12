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

    /**
     * Display the admin listing of all resources in DB
     */
    public function all(Request $request)
    {
        return view('pages.user.index', [
            'users' => User::paginate($request->query('limit') ?? 10, ['*'], 'users'),
        ]);
    }

    /**
     * Display all resources related to model
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $this->authorize('viewAny', User::class);

        return view('pages.user.index', [
            'users' => $this->userService
                ->getMyTeamMembers($user)
                ->paginate($request->query('limit') ?? 10)
        ]);
    }

    /**
     * Display a single resource
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('pages.user.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $this->userService
            ->createOne($attributes, Auth::user());

        return back()
            ->with('message', self::responseMessage('success', 'User created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        if ($user->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage('error', 'Please update your own details from profile section'));
        }

        return view('pages.user.update', [
            'user' => $user,
            'addresses' => $user->addresses()->get(),
            'contacts' => $user->contacts()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage('error', 'Please update your own details from profile section'));
        }

        User::updateOrCreate(
            ['id' => $user->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'active' => $request->boolean('active'),
            ]
        );

        return back()
            ->with('message', self::responseMessage('success', 'User updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage('error', 'You cannot delete your own account'));
        }

        $user = User::findOrFail($user->id);
        $user->delete();

        return redirect()
            ->intended(route('users.index'))
            ->with('message', self::responseMessage('warning', 'User removed'));
    }

    /**
     * Show the page with previously removed item
     */
    public function removed(Request $request)
    {
        $this->authorize('viewTrashed', User::class);

        return view('pages.user.removed', [
            'users' => $this->userService
                ->getMyTeamMembers(Auth::user())
                ->onlyTrashed()
                ->paginate($request->query('limit') ?? 10),
        ]);
    }

    /**
     * Restore a given item
     */
    public function restore(string|int $userId)
    {
        $user = User::onlyTrashed()->find($userId);
        $this->authorize('restore', $user);
        $user->restore();

        return redirect()
            ->intended(route('users.removed'))
            ->with('message', self::responseMessage('success', 'User restored'));
    }
}
