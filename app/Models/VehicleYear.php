<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\VehicleYearFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @method static VehicleYearFactory factory($count = null, $state = [])
 * @method static Builder<static>|VehicleYear newModelQuery()
 * @method static Builder<static>|VehicleYear newQuery()
 * @method static Builder<static>|VehicleYear onlyTrashed()
 * @method static Builder<static>|VehicleYear query()
 * @method static Builder<static>|VehicleYear whereCreatedAt($value)
 * @method static Builder<static>|VehicleYear whereId($value)
 * @method static Builder<static>|VehicleYear whereUpdatedAt($value)
 * @method static Builder<static>|VehicleYear whereVehicleModelId($value)
 * @method static Builder<static>|VehicleYear whereYear($value)
 * @method static Builder<static>|VehicleYear withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|VehicleYear withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperVehicleYear
 */
class VehicleYear extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

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
