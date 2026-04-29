<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserAddressStoreAction;
use App\Actions\UserContactStoreAction;
use App\Actions\UserStoreAction;
use App\Actions\UserUpdateAction;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\StoreUserContactRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Address;
use App\Models\Contact;
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
     * Display the admin listing of all resources in DB
     */
    public function all(Request $request): View
    {
        return view('pages.user.index', [
            'users' => User::paginate($request->query('limit') ?? 10, ['*'], 'users'),
        ]);
    }

    /**
     * Display all resources related to model
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $this->authorize('viewAny', User::class);

        return view('pages.user.index', [
            'users' => $this->userService
                ->getMyTeamMembers($user)
                ->paginate(
                    $request->query('limit') ?? 10,
                    ['users.id', 'name', 'email', 'active', 'image_path'],
                    'users'
                ),
        ]);
    }

    /**
     * Display a single resource
     */
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        return view('pages.user.show', [
            'user' => $user,
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
                'The user has been successfully created and added to the team.'
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): RedirectResponse|View
    {
        $this->authorize('edit', $user);

        if ($user->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage(
                    'error',
                    'User update error',
                    'Please update your own details from profile section.'
                ));
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
    public function update(UpdateUserRequest $request, User $user, UserUpdateAction $action): RedirectResponse
    {
        if ($user->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage(
                    'error',
                    'User update error',
                    'Please update your own details from profile section'
                ));
        }

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');

        $action->handle($attributes, $user);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'User updated',
                'The user details have been successfully updated.'
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
                    'You cannot delete your own account'
                ));
        }

        $user = User::findOrFail($user->id);
        $user->delete();

        return redirect()
            ->intended(route('users.index'))
            ->with('message', self::responseMessage(
                'info',
                'User removed',
                'The user has been successfully removed from the team.'
            ));
    }

    /**
     * Show the page with previously removed item
     */
    public function removed(Request $request): View
    {
        $this->authorize('viewTrashed', User::class);

        return view('pages.user.removed', [
            'users' => $this->userService
                ->getMyTeamMembers(Auth::user())
                ->onlyTrashed()
                ->paginate(
                    $request->query('limit') ?? 10,
                    ['users.id', 'name', 'email', 'active', 'image_path'],
                    'users'
                ),
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

        return redirect()
            ->intended(route('users.removed'))
            ->with('message', self::responseMessage(
                'success',
                'User restored',
                'The user has been successfully restored and is now active again.'
            ));
    }

    public function addAddress(StoreUserAddressRequest $request, User $user, UserAddressStoreAction $action): RedirectResponse
    {
        $action->handle($request->safe()->all(), $user);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Address added',
                'User\'s address has been created and attached'
            ));
    }

    public function removeAddress(User $user, Address $address): RedirectResponse
    {
        $this->authorize('removeAddress', $user);
        $user->addresses()->detach($address);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Address removed',
                'User\'s address has been removed'
            ));
    }

    public function addContact(StoreUserContactRequest $request, User $user, UserContactStoreAction $action): RedirectResponse
    {
        $action->handle($request->safe()->all(), $user);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Contact created',
                'Contact information has been created and attached'
            ));
    }

    public function removeContact(User $user, Contact $contact): RedirectResponse
    {
        $this->authorize('removeContact', $user);
        $user->contacts()->detach($contact);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Contact removed',
                'Contact information has been removed'
            ));
    }
}
