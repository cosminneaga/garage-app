<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleData> $data
 * @property-read int|null $data_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VehicleModel> $models
 * @property-read int|null $models_count
 * @method static \Database\Factories\VehicleMakeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleMake withoutTrashed()
 * @mixin \Eloquent
 */
class VehicleMake extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function models(): HasMany
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(VehicleData::class);
    }
}
