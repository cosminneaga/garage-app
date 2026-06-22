<?php

namespace App\Http\Controllers;

use App\Actions\UserStoreAction;
use App\Actions\UserUpdateAction;
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

class AdministratorController extends Controller
{
    use ResponseMessage;

    public function __construct(protected UserService $user_service)
    {
        //
    }/**
     * Display all resources related to model
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $querySearch = $request->string('search')->value();

        return view('pages.administrator.index', [
            'administrators' => User::role(UserRole::ADMINISTRATOR->value)->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('pages.administrator.create', [
            'countries' => Country::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserStoreAction $action): RedirectResponse
    {
        $administrator = User::role('administrator')->exists();
        abort_if($administrator, 403, 'Administrator is already created');

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes);

        return redirect(route('administrators.index'))
            ->with('message', self::responseMessage(
                'success',
                'User created',
                'The user has been successfully created and added to the team.',
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $administrator): RedirectResponse|View
    {
        $this->authorize('view', $administrator);

        if ($administrator->id === Auth::user()->id) {
            return redirect()->route('users.profile.edit', $administrator);
        }

        return match(request()->query('tab')) {
            'statistics' => view('pages.administrator.edit.statistics', [
                'administrator' => $administrator,
            ]),
            'contacts' => view('pages.administrator.edit.contacts', [
                'user' => $administrator,
            ]),
            'addresses' => view('pages.administrator.edit.addresses', [
                'user' => $administrator,
                'countries' => Country::all(),
            ]),
            default => view('pages.administrator.edit.index', [
                'administrator' => $administrator,
            ]),
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $administrator, UserUpdateAction $action): RedirectResponse
    {
        if ($administrator->id === Auth::user()->id) {
            return back()
                ->with('message', self::responseMessage(
                    'error',
                    'User update error',
                    'Please update your own details from profile section',
                ));
        }

        $attributes = $request->safe()->all();
        $attributes['active'] = $request->boolean('active');
        $action->handle($attributes, $administrator);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Administrator updated',
                'The administrator details have been successfully updated.',
            ));
    }
}
