<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin Model
 *
 * @method static void creating(Model $model)
 * @method static void updating(Model $model)
 * @method static void deleting(Model $model)
 */
trait Blameable
{
    public static function bootBlameable(): void
    {
        static::creating(function (Model $model) {
            $actor = Auth::guard('web')->user() ?? Auth::guard('client')->user();

            if (!$actor) {
                return;
            }

            if ($model->usesPolymorphicBlame()) {
                $model->createdByActor()->associate($actor);
                $model->updatedByActor()->associate($actor);
                $model->deletedByActor()->dissociate();

                return;
            }


            $model->created_by ??= Auth::id();
            $model->updated_by ??= Auth::id();
            $model->deleted_by = null;
        });

        static::updating(function (Model $model) {
            $actor = Auth::guard('web')->user() ?? Auth::guard('client')->user();

            if (!$actor) {
                return;
            }

            if ($model->usesPolymorphicBlame()) {
                $model->updatedByActor()->associate($actor);

                return;
            }


            $model->updated_by = Auth::id();
        });

        static::deleting(function (Model $model) {
            $actor = Auth::guard('web')->user() ?? Auth::guard('client')->user();

            if (!$actor) {
                return;
            }

            if ($model->usesPolymorphicBlame()) {
                $model->deletedByActor()->associate($actor);
                $model->saveQuietly();

                return;
            }

            $model->deleted_by = Auth::id();
            $model->saveQuietly();
        });
    }

    protected function usesPolymorphicBlame(): bool
    {
        return false;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletor()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function createdByActor(): MorphTo
    {
        return $this->morphTo(
            'createdByActor',
            'created_by_type',
            'created_by'
        );
    }

    public function updatedByActor(): MorphTo
    {
        return $this->morphTo(
            'updatedByActor',
            'updated_by_type',
            'updated_by',
        );
    }

    public function deletedByActor(): MorphTo
    {
        return $this->morphTo(
            'deletedByActor',
            'deleted_by_type',
            'deleted_by',
        );
    }
}
