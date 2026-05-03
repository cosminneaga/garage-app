<?php

namespace App\Http\Controllers;

use App\Actions\ModelContactStoreAction;
use App\Http\Requests\StoreContactRequest;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\CompanyPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use App\Traits\ResponseMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request, string|int $id, ModelContactStoreAction $action): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];

        $entity = match ($type) {
            'user' => User::findOrFail($id),
            'company' => Company::findOrFail($id),
            'supplier' => Supplier::findOrFail($id),
        };

        $action->handle($request->safe()->all(), $entity);

        return back()
            ->with('message', self::responseMessage(
                'success',
                'Resource created',
                'Contact has been created and attached to given resource'
            ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string|int $id, string|int $contactId): View
    {
        $type = array_keys($request->route()->parameters())[0];

        $entity = match ($type) {
            'user' => User::findOrFail($id),
            'company' => Company::findOrFail($id),
            'supplier' => Supplier::findOrFail($id),
        };

        if ($entity instanceof User) {
            app(UserPolicy::class)->view(Auth::user(), $entity);
        } else if ($entity instanceof Company) {
            app(CompanyPolicy::class)->view(Auth::user(), $entity);
        } elseif ($entity instanceof Supplier) {
            app(SupplierPolicy::class)->view(Auth::user(), $entity);
        }

        return view('pages.contact.show', [
            'contact' => $entity->contacts()->findOrFail($contactId),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string|int $id, string|int $contactId): RedirectResponse
    {
        $type = array_keys($request->route()->parameters())[0];

        $entity = match ($type) {
            'user' => User::findOrFail($id),
            'company' => Company::findOrFail($id),
            'supplier' => Supplier::findOrFail($id),
        };

        if ($entity instanceof User) {
            app(UserPolicy::class)->removeAddress(Auth::user(), $entity);
        } else if ($entity instanceof Company) {
            app(CompanyPolicy::class)->removeAddress(Auth::user(), $entity);
        } elseif ($entity instanceof Supplier) {
            app(SupplierPolicy::class)->removeAddress(Auth::user(), $entity);
        }

        $entity->contacts()->detach($contactId);

        return back()
            ->with('message', self::responseMessage(
                'info',
                'Resource removed',
                'Contact has been removed from given resource'
            ));
    }
}
