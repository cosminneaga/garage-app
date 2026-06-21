<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\UserStoreAction;
use App\Actions\UserUpdateAction;
use App\Enums\Resource\ResourceFilter;
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

class ManagerController extends Controller
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

        return view('pages.manager.index', [
            'managers' => $this->userService
                ->search($querySearch)
                ->team(UserRole::MANAGER)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('pages.manager.create', [
            'countries' => Country::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserStoreAction $action): RedirectResponse
    {
        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes);

        return redirect(route('managers.index'))
            ->with('message', self::responseMessage(
                'success',
                'User created',
                'The user has been successfully created and added to the team.',
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $manager): RedirectResponse|View
    {
        $this->authorize('viewManager', $manager);

        if ($manager->id === Auth::user()->id) {
            return redirect()->route('users.profile.edit', $manager);
        }

        return match(request()->query('tab')) {
            'statistics' => view('pages.manager.edit.statistics', [
                'manager' => $manager,
            ]),
            'contacts' => view('pages.manager.edit.contacts', [
                'user' => $manager,
            ]),
            'addresses' => view('pages.manager.edit.addresses', [
                'user' => $manager,
                'countries' => Country::all(),
            ]),
            default => view('pages.manager.edit.index', [
                'manager' => $manager,
            ]),
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $manager, UserUpdateAction $action): RedirectResponse
    {
        if ($manager->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage(
                    'error',
                    'User update error',
                    'Please update your own details from profile section',
                ));
        }

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes, $manager);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Manager updated',
                'The manager details have been successfully updated.',
            ));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $manager): RedirectResponse
    {
        $this->authorize('deleteManager', $manager);

        if ($manager->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage(
                    'error',
                    'User delete error',
                    'You cannot delete your own account',
                ));
        }

        $manager = User::findOrFail($manager->id);
        $manager->delete();

        return redirect(route('managers.index'))
            ->with('message', self::responseMessage(
                'info',
                'Manager removed',
                'The manager ' . $manager->name . ' has been successfully removed from the team.',
            ));
    }

    /**
     * Show the page with previously removed item
     */
    public function removed(Request $request): View
    {
        $this->authorize('viewTrashed', User::class);
        $querySearch = $request->string('search')->value();

        return view('pages.manager.removed', [
            'managers' => $this->userService
                ->search($querySearch)
                ->team(UserRole::MANAGER, ResourceFilter::ONLY_TRASHED)
                ->paginate($request->integer('limit') ?? 10),
        ]);
    }

    /**
     * Restore a given item
     */
    public function restore(string|int $managerId): RedirectResponse
    {
        $manager = User::onlyTrashed()->findOrFail($managerId);
        $this->authorize('restoreManager', $manager);
        $manager->restore();

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Manager restored',
                'The manager has been successfully restored and is now active again.',
            ));
    }
}
