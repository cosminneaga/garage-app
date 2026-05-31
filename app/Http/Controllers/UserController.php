<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserStoreAction;
use App\Actions\UserUpdateAction;
use App\Enums\Resource\ResourceFilter;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Country;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
     * Display all resources related to model
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $querySearch = $request->string('search')->value();

        return view('pages.user.index', [
            'users' => $this->userService
                ->search($querySearch)
                ->filterOwn(ResourceFilter::DEFAULT)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Auth::user());

        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserStoreAction $action): RedirectResponse
    {
        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');

        $action->handle($attributes);

        return redirect(route('users.index'))
            ->with('message', self::responseMessage(
                'success',
                'User created',
                'The user has been successfully created and added to the team.',
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): RedirectResponse|View
    {
        $this->authorize('edit', $user);

        if ($user->id === Auth::user()->id) {
            return redirect()->route('users.profile.edit', $user);
        }

        return match(request()->query('tab')) {
            'statistics' => view('pages.user.edit.statistics', [
                'user' => $user,
            ]),
            'contacts' => view('pages.user.edit.contacts', [
                'user' => $user,
            ]),
            'addresses' => view('pages.user.edit.addresses', [
                'user' => $user,
                'countries' => Country::all(),
            ]),
            default => view('pages.user.edit.index', [
                'user' => $user,
            ]),
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UserUpdateAction $action): RedirectResponse
    {
        if ($user->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage(
                    'error',
                    'User update error',
                    'Please update your own details from profile section',
                ));
        }

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');

        $action->handle($attributes, $user);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'User updated',
                'The user details have been successfully updated.',
            ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        if ($user->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage(
                    'error',
                    'User delete error',
                    'You cannot delete your own account',
                ));
        }

        $user = User::findOrFail($user->id);
        $user->delete();

        return redirect(route('users.index'))
            ->with('message', self::responseMessage(
                'info',
                'User removed',
                'The user ' . $user->name . ' has been successfully removed from the team.',
            ));
    }

    /**
     * Show the page with previously removed item
     */
    public function removed(Request $request): View
    {
        $this->authorize('viewTrashed', User::class);
        $querySearch = $request->string('search')->value();

        return view('pages.user.removed', [
            'users' => $this->userService
                ->search($querySearch)
                ->filterOwn(ResourceFilter::ONLY_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    /**
     * Restore a given item
     */
    public function restore(string|int $userId): RedirectResponse
    {
        $user = User::onlyTrashed()->find($userId);
        $this->authorize('restore', $user);
        $user->restore();

        return back()
            ->with('message', self::responseMessage(
                'success',
                'User restored',
                'The user has been successfully restored and is now active again.',
            ));
    }

    // ADMIN
    public function all(Request $request): View
    {
        $querySearch = $request->string('search')->value();

        return view('pages.user.admin', [
            'users' => $this->userService
                ->search($querySearch)
                ->filterAll(ResourceFilter::WITH_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }
}
