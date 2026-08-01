<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\Related\RelatedModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

trait RelatedModelGuard
{
    public static ?User $user;
    public static ?Model $entity;
    public static ?string $policy;
    public static ?string $relatedName;
    public static ?RelatedModel $relatedModel;

    public static function guard(string $action, Request $request, string|int $modelId): void
    {
        self::$user = Auth::user();

        self::$relatedName = Collection::make($request->route()->parameters())
            ->keys()
            ->last();

        self::$relatedModel = RelatedModel::from(self::$relatedName);
        self::$entity = self::$relatedModel->entity($modelId);
        self::$policy = self::$relatedModel->policy();

        match ($action) {
            'show' => self::_show(),
            'create' => self::_create(),
            'update' => self::_update(),
            'destroy' => self::_destroy(),
            'restore' => self::_restore(),
            'showTrashed' => self::_showTrashed(),
            default => self::_show(),
        };
    }

    public static function guardAll(string $action, Request $request): void
    {
        self::$user = Auth::user();
        self::$relatedModel = $request->route()->getAction('model');
        self::$relatedName = self::$relatedModel->value;
        self::$policy = RelatedModel::from(self::$relatedName)->policy();

        match ($action) {
            'show_all' => self::_showAll(),
            'show_trashed' => self::_showTrashed(),
            default => self::_showAll(),
        };
    }

    protected static function _show(): void
    {
        abort_unless(
            App::make(self::$policy)->show(self::$user, self::$entity),
            401
        );
    }

    protected static function _create(): void
    {
        abort_unless(
            App::make(self::$policy)->store(),
            401
        );
    }

    protected static function _update(): void
    {
        abort_unless(
            App::make(self::$policy)->update(self::$user, self::$entity),
            401
        );
    }

    protected static function _destroy(): void
    {
        abort_unless(
            App::make(self::$policy)->destroy(self::$user, self::$entity),
            401
        );
    }

    protected static function _restore(): void
    {
        abort_unless(
            App::make(self::$policy)->restore(self::$user, self::$entity),
            401
        );
    }

    protected static function _showTrashed(): void
    {
        abort_unless(
            App::make(self::$policy)->showTrashed(),
            401
        );
    }

    protected static function _showAll(): void
    {
        abort_unless(
            App::make(self::$policy)->showAll(),
            401
        );
    }
}
