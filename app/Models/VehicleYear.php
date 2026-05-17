<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $year
 * @property int $vehicle_model_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, VehicleData> $data
 * @property-read int|null $data_count
 * @property-read VehicleModel|null $model
 *
 * @method static \Database\Factories\VehicleYearFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereVehicleModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleYear withoutTrashed()
 *
 * @mixin \Eloquent
 */
class VehicleYear extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [];

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(VehicleData::class);
    }
}
