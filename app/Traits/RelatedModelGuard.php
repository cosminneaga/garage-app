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

    public static function guard(string $action, Request $request, string|int $modelId): void
    {
        self::$user = Auth::user();

        $name = Collection::make($request->route()->parameters())
        ->keys()
        ->last();
        self::$relatedName = $name;
        $entity = RelatedModel::from($name)->entity($modelId);
        $policy = RelatedModel::from($name)->policy();

        self::$entity = $entity;
        self::$policy = $policy;

        match($action) {
            'show' => self::_show(),
            'create' => self::_create(),
            'update' => self::_update(),
            'destroy' => self::_destroy(),
            'restore' => self::_restore(),
            'showTrashed' => self::_showTrashed(),
            default => self::_show(),
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
}
