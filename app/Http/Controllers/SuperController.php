<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;

class SuperController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    public function users(Request $request)
    {
        $search = $request->string('search')->value();

        return view('pages.super.users.index', [
            'data' => User::search($search)->paginate(10),
        ]);
    }

    public function companies(Request $request)
    {
        $search = $request->string('search')->value();

        return view('pages.super.companies.index', [
            'data' => Company::search($search)->paginate(10),
        ]);
    }

    public function suppliers(Request $request)
    {
        $search = $request->string('search')->value();

        return view('pages.super.suppliers.index', [
            'data' => Supplier::search($search)->paginate(10),
        ]);
    }

    public function modelIndex(
        Request $request
    ) {
        # self::guard('show', $request, null);

        # perform action to show all resources
    }

    public function modelStore(
        Request $request,
        string|int $model_id
    ) {
        self::guard('create', $request, $model_id);

        # perform action to store the resource
    }

    public function modelEdit(
        Request $request,
        string|int $model_id
    ) {
        self::guard('show', $request, $model_id);

        # perform action to show resource information including related resources, like address, contact
        return match (request()->query('tab')) {
            'statistics' => '',
            'contacts' => '',
            'addresses' => '',
            default => ''
        };
    }

    public function modelUpdate(
        Request $request,
        string|int $model_id
    ) {
        self::guard('update', $request, $model_id);

        # perform action to update single resource
    }

    public function modelDestroy(
        Request $request,
        string|int $model_id
    ) {
        self::guard('delete', $request, $model_id);

        # perform action to destroy single resource
    }

    public function modelRemoved(
        Request $request
    ) {
        # self::guard('showTrashed', $request);

        # perform action to show removed resources
    }

    public function modelRestore(
        Request $request,
        string|int $model_id
    ) {
        self::guard('restore', $request, $model_id);

        # perform action to restore single resource
    }
}
