<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserStoreAction;
use App\Actions\UserUpdateAction;
use App\Enums\Resource\ResourceFilter;
use App\Enums\Tabs\NotificationTabs;
use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Country;
use App\Models\User;
use App\Policies\PermissionPolicy;
use App\Services\UserService;
use App\Traits\RelatedModelGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UserController extends Controller
{
    use RelatedModelGuard;

    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index(Request $request)
    {
        $this->authorize('showAll', User::class);
        $querySearch = $request->string('search')->value();

        return view('pages.user.index', [
            'users' => $this->userService
                ->search($querySearch)
                ->team(UserRole::USER)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('store', Auth::user());

        return view('pages.user.create', [
            'countries' => Country::all(),
        ]);
    }

    public function store(StoreUserRequest $request, UserStoreAction $action): RedirectResponse
    {
        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes);

        return redirect(route('users.index'))
            ->with(self::flashMessage(
                'success',
                'User created',
                'The user has been successfully created and added to the team',
            ));
    }

    public function edit(User $user): RedirectResponse|View
    {
        $this->authorize('show', $user);

        if ($user->id === Auth::user()->id) {
            return redirect()->route('profile.users.edit', $user);
        }

        # guards
        if (FacadesRequest::query('tab') === 'permissions') {
            abort_unless(App::make(PermissionPolicy::class)->show(), 401);
        }

        return match(FacadesRequest::query('tab')) {
            'statistics' => view('pages.user.edit.statistics', [
                'resource' => $user,
            ]),
            'contacts' => view('pages.user.edit.contacts', [
                'resource' => $user,
            ]),
            'addresses' => view('pages.user.edit.addresses', [
                'resource' => $user,
                'countries' => Country::all(),
            ]),
            'permissions' => view('pages.user.edit.permissions', [
                'resource' => $user,
                'permissions' => UserPermission::tableStructure($user->getAllPermissions()),
            ]),
            default => view('pages.user.edit.index', [
                'resource' => $user,
            ]),
        };
    }

    public function update(
        UpdateUserRequest $request,
        User $user,
        UserUpdateAction $action
    ): RedirectResponse {
        if ($user->id === Auth::user()->id) {
            return back()
                ->with(self::flashMessage(
                    'error',
                    'User update error',
                    'Please update your own details from profile section',
                ));
        }

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes, $user);

        return back()
            ->with(self::flashMessage(
                'success',
                'User updated',
                'The user details have been successfully updated.',
            ));
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('destroy', $user);

        if ($user->id === Auth::user()->id) {
            return back()
                ->with(self::flashMessage(
                    'error',
                    'User delete error',
                    'You cannot delete your own account',
                ));
        }

        $user = User::findOrFail($user->id);
        $user->delete();

        if (Auth::user()->isSuper()) {
            return redirect()
                ->intended(route('super.users.all'))
                ->with(self::flashMessage(
                    'info',
                    'User removed',
                    'The user ' . $user->name . ' has been successfully removed from the team',
                ));
        }

        return redirect()
            ->intended(route('users.index'))
            ->with(self::flashMessage(
                'info',
                'User removed',
                'The user ' . $user->name . ' has been successfully removed from the team',
            ));
    }

    public function removed(Request $request): View
    {
        $this->authorize('showTrashed', User::class);
        $querySearch = $request->string('search')->value();

        return view('pages.user.removed', [
            'users' => $this->userService
                ->search($querySearch)
                ->team(UserRole::USER, ResourceFilter::ONLY_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    public function restore(string|int $userId): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($userId);
        $this->authorize('restore', $user);
        $user->restore();

        return back()
            ->with(self::flashMessage(
                'success',
                'User restored',
                'The user has been successfully restored and is now active again.',
            ));
    }

    public function notifications(): View
    {
        return match(FacadesRequest::query('tab')) {
            NotificationTabs::UNREAD->value => view('pages.user.notifications.unread'),
            NotificationTabs::READ->value => view('pages.user.notifications.read'),
            NotificationTabs::ALL->value => view('pages.user.notifications.all'),
            default => view('pages.user.notifications.unread'),
        };
    }

    public function notificationRead(string $notificationId): RedirectResponse
    {
        Auth::user()->notifications()->find($notificationId)->markAsRead();

        return back()
            ->with(self::flashMessage(
                'success',
                'Notification read',
                'Notification has been read'
            ));
    }

    /**
     * Attach an user to a related resource
     */
    public function modelAttach(Request $request, User $user, string|int $modelId)
    {
        self::guard('update', $request, $modelId);
        $this->authorize('update', $user);

        # check if user is linked
        abort_unless(!self::$entity->users()->find($user), 404);
        self::$entity->users()->attach($user);

        return back()
            ->with(self::flashMessage(
                'success',
                'User linked',
                'User has been linked to ' . self::$relatedName
            ));
    }

    /**
     * Detach an user from a related resource
     */
    public function modelDetach(Request $request, User $user, string|int $modelId): RedirectResponse
    {
        self::guard('update', $request, $modelId);
        $this->authorize('update', $user);

        self::$entity->users()->detach($user);

        return back()
            ->with(self::flashMessage(
                'warning',
                'User unlinked',
                'User has been unlinked from ' . self::$relatedName
            ));
    }

    /**
     * Store a resource to related to an user
     */
    public function modelStore(StoreUserRequest $request, string|int $modelId, UserStoreAction $action): RedirectResponse
    {
        self::guard('update', $request, $modelId);
        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $user = $action->handle($attributes);

        self::$entity->users()->attach($user);
        Auth::user()->memberAttach($user);

        return back()
          ->with(self::flashMessage(
              'success',
              'User created & linked',
              'User has been created and linked to ' . self::$relatedName,
          ));
    }

    /**
     * Assign permission to an user
     */
    public function assignPermission(User $user, string $name): RedirectResponse
    {
        $this->authorize('update', $user);
        abort_unless(App::make(PermissionPolicy::class)->assign(), 401);
        $user->givePermissionTo($name);

        return back()
            ->with(self::flashMessage(
                'success',
                'Permission assigned',
                'Permission assigned to user ' . $user->name
            ));
    }

    /**
     * Revoke permission from an user
     */
    public function revokePermission(User $user, string $name): RedirectResponse
    {
        $this->authorize('update', $user);
        abort_unless(App::make(PermissionPolicy::class)->revoke(), 401);
        $user->revokePermissionTo($name);

        return back()
            ->with(self::flashMessage(
                'success',
                'Permission revoked',
                'Permission revoked from user ' . $user->name
            ));
    }
}
