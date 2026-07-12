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

    public static function guard(Request $request, string|int $modelId): self
    {
        self::$user = Auth::user();

        $name = Collection::make($request->route()->parameters())
            ->keys()
            ->last();
        $entity = RelatedModel::from($name)->entity($modelId);
        $policy = RelatedModel::from($name)->policy();

        self::$entity = $entity;
        self::$policy = $policy;

        return new static();
    }

    public static function show(): self
    {
        abort_unless(
            App::make(self::$policy)->view(self::$user, self::$entity),
            401
        );

        return new static();
    }

    public static function create(): self
    {
        abort_unless(
            App::make(self::$policy)->create(),
            401
        );

        return new static();
    }

    public static function update(): self
    {
        abort_unless(
            App::make(self::$policy)->edit(self::$user, self::$entity),
            401
        );

        return new static();
    }

    public static function destroy(): self
    {
        abort_unless(
            App::make(self::$policy)->delete(self::$user, self::$entity),
            401
        );

        return new static();
    }

    public static function restore(): self
    {
        abort_unless(
            App::make(self::$policy)->restore(self::$user, self::$entity),
            401
        );

        return new static();
    }

    public static function showTrashed(): self
    {
        abort_unless(
            App::make(self::$policy)->viewTrashed(),
            401
        );

        return new static();
    }
}
