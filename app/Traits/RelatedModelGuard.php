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
            'show' => self::show(),
            'create' => self::create(),
            'destroy' => self::destroy(),
            'restore' => self::restore(),
            'showTrashed' => self::showTrashed(),
            default => self::show(),
        };
    }

    protected static function show(): void
    {
        abort_unless(
            App::make(self::$policy)->show(self::$user, self::$entity),
            401
        );
    }

    protected static function create(): void
    {
        abort_unless(
            App::make(self::$policy)->store(),
            401
        );
    }

    protected static function update(): void
    {
        abort_unless(
            App::make(self::$policy)->update(self::$user, self::$entity),
            401
        );
    }

    protected static function destroy(): void
    {
        abort_unless(
            App::make(self::$policy)->destroy(self::$user, self::$entity),
            401
        );
    }

    protected static function restore(): void
    {
        abort_unless(
            App::make(self::$policy)->restore(self::$user, self::$entity),
            401
        );
    }

    protected static function showTrashed(): void
    {
        abort_unless(
            App::make(self::$policy)->showTrashed(),
            401
        );
    }
}
