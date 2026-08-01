<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App;
use App\Enums\UserPermission;
use App\Models\Country;
use App\Traits\RelatedModelGuard;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class SuperController extends Controller
{
    use ResponseMessage;
    use RelatedModelGuard;

    /**
     * !!!NOTE: pages.super.suppliers.index must exists
     */
    public function modelIndex(
        Request $request
    ) {
        self::guardAll('show_all', $request);

        $search = FacadesRequest::query('search');
        $name = self::$relatedModel->tableName();
        $instance = self::$relatedModel->instance();

        return view('pages.super.' . $name . '.index', [
            'data' => App::make($instance)->search($search)->paginate(10),
        ]);
    }

    public function modelStore(
        Request $request,
        string|int $model_id
    ): void {
        self::guard('create', $request, $model_id);

        # perform action to store the resource
    }

    public function modelEdit(
        Request $request,
        string|int $model_id
    ) {
        self::guard('show', $request, $model_id);
        $name = self::$relatedModel->tableName();

        return match (request()->query('tab')) {
            'statistics' => view('pages.super.' . $name . '.edit.statistics', [
                'resource' => self::$entity,
            ]),
            'members' => view('pages.super.' . $name . '.edit.members', [
                'resource' => self::$entity,
                'countries' => Country::all(),
                'non_members' => [], // !!! momentarily on hold
                'members' => self::$entity->users()->get(),
            ]),
            'contacts' => view('pages.super.' . $name . '.edit.contacts', [
                'resource' => self::$entity,
            ]),
            'addresses' => view('pages.super.' . $name . '.edit.addresses', [
                'resource' => self::$entity,
                'countries' => Country::all(),
            ]),
            'permissions' => view('pages.super.' . $name . '.edit.permissions', [
                'resource' => self::$entity,
                'permissions' => UserPermission::tableStructure(self::$entity->getAllPermissions()),
            ]),
            'suppliers' => view('pages.super.' . $name . '.edit.suppliers', [
                'resource' => self::$entity,
                'countries' => Country::all(),
            ]),
            default => view('pages.super.' . $name . '.edit.index', [
                'resource' => self::$entity,
            ]),
        };
    }

    public function modelUpdate(
        Request $request,
        string|int $model_id
    ) {
        self::guard('update', $request, $model_id);

        $validated = App::make(self::$relatedModel->request()->update)
            ->merge($request->all())
            ->validated();
        self::$entity->update($validated);

        return back()
            ->with(self::flashMessage(
                'success',
                'Resource updated',
                'Resource has been successfully updated'
            ));
    }

    public function modelDestroy(
        Request $request,
        string|int $model_id
    ) {
        self::guard('destroy', $request, $model_id);
        self::$entity->delete();
        $name = self::$relatedModel->tableName();

        return redirect()
            ->intended(route('super.' . $name . '.all'))
            ->with(self::flashMessage(
                'info',
                'Resource removed',
                'Resource has been successfully removed'
            ));
    }

    public function modelRemoved(
        Request $request
    ) {
        self::guardAll('show_trashed', $request);

        $search = FacadesRequest::query('search');
        $name = self::$relatedModel->tableName();
        $instance = self::$relatedModel->instance();

        return view('pages.super.' . $name . '.removed', [
            'data' => App::make($instance)->search($search)->onlyTrashed()->paginate(10),
        ]);
    }

    public function modelRestore(
        Request $request,
        string|int $model_id
    ) {
        self::guard('restore', $request, $model_id);
        self::$entity->restore();
        $name = self::$relatedModel->tableName();

        return redirect()
            ->intended(route('super.' . $name . '.removed'))
            ->with(self::flashMessage(
                'success',
                'Resource restored',
                'Resource has been successfully restored',
            ));
    }
}
