<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserStoreAction;
use App\Actions\UserUpdateAction;
use App\Enums\Resource\ResourceFilter;
use App\Enums\UserPermission;
use App\Enums\UserRole;
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
use Illuminate\Support\Facades\Request as FacadesRequest;

class ManagerController extends Controller
{
    use ResponseMessage;

    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index(Request $request)
    {
        $this->authorize('showAll', User::class);
        $querySearch = $request->string('search')->value();

        return view('pages.manager.index', [
            'data' => $this->userService
                ->search($querySearch)
                ->team(UserRole::MANAGER)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('store', User::class);

        return view('pages.manager.create', [
            'countries' => Country::all(),
        ]);
    }

    public function store(
        StoreUserRequest $request,
        UserStoreAction $action
    ): RedirectResponse {
        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes);

        return redirect(route('managers.index'))
            ->with(self::flashMessage(
                'success',
                'Manager created',
                'The manager has been successfully created and added to the team',
            ));
    }

    public function edit(User $manager): RedirectResponse|View
    {
        $this->authorize('show', $manager);

        if ($manager->id === Auth::user()->id) {
            return redirect()->route('profile.users.edit', $manager);
        }

        return match(FacadesRequest::query('tab')) {
            'statistics' => view('pages.manager.edit.statistics', [
                'manager' => $manager,
            ]),
            'contacts' => view('pages.manager.edit.contacts', [
                'resource' => $manager,
            ]),
            'addresses' => view('pages.manager.edit.addresses', [
                'resource' => $manager,
                'countries' => Country::all(),
            ]),
            'permissions' => view('pages.user.edit.permissions', [
                'resource' => $manager,
                'permissions' => UserPermission::tableStructure($manager->getAllPermissions()),
            ]),
            default => view('pages.manager.edit.index', [
                'resource' => $manager,
            ]),
        };
    }

    public function update(
        UpdateUserRequest $request,
        User $manager,
        UserUpdateAction $action
    ): RedirectResponse {
        if ($manager->id === Auth::user()->id) {
            return back()
                ->with(self::flashMessage(
                    'error',
                    'User update error',
                    'Please update your own details from profile section',
                ));
        }

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes, $manager);

        return back()
            ->with(self::flashMessage(
                'success',
                'Manager updated',
                'The manager details have been successfully updated',
            ));
    }

    public function destroy(User $manager): RedirectResponse
    {
        $this->authorize('destroy', $manager);

        if ($manager->id === Auth::user()->id) {
            return back()
                ->with(self::flashMessage(
                    'error',
                    'User delete error',
                    'You cannot delete your own account',
                ));
        }

        $manager = User::findOrFail($manager->id);
        $manager->delete();

        return redirect(route('managers.index'))
            ->with(self::flashMessage(
                'info',
                'Manager removed',
                'The manager ' . $manager->name . ' has been successfully removed from the team',
            ));
    }

    public function restore(string|int $managerId): RedirectResponse
    {
        $manager = User::onlyTrashed()->findOrFail($managerId);
        $this->authorize('restore', $manager);
        $manager->restore();

        return back()
            ->with(self::flashMessage(
                'success',
                'Manager restored',
                'The manager has been successfully restored and is now active again',
            ));
    }

    public function removed(Request $request): View
    {
        $this->authorize('showTrashed', User::class);
        $querySearch = $request->string('search')->value();

        return view('pages.manager.removed', [
            'managers' => $this->userService
                ->search($querySearch)
                ->team(UserRole::MANAGER, ResourceFilter::ONLY_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }
}
