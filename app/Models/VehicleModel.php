<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\VehicleModelFactory;
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
 * @property string $name
 * @property string $class
 * @property int $vehicle_make_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, VehicleData> $data
 * @property-read int|null $data_count
 * @property-read VehicleMake|null $make
 * @property-read Collection<int, VehicleYear> $years
 * @property-read int|null $years_count
 * @method static VehicleModelFactory factory($count = null, $state = [])
 * @method static Builder<static>|VehicleModel newModelQuery()
 * @method static Builder<static>|VehicleModel newQuery()
 * @method static Builder<static>|VehicleModel onlyTrashed()
 * @method static Builder<static>|VehicleModel query()
 * @method static Builder<static>|VehicleModel whereClass($value)
 * @method static Builder<static>|VehicleModel whereCreatedAt($value)
 * @method static Builder<static>|VehicleModel whereId($value)
 * @method static Builder<static>|VehicleModel whereName($value)
 * @method static Builder<static>|VehicleModel whereUpdatedAt($value)
 * @method static Builder<static>|VehicleModel whereVehicleMakeId($value)
 * @method static Builder<static>|VehicleModel withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|VehicleModel withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperVehicleModel
 */
class VehicleModel extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [];

    public function make(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(VehicleYear::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(VehicleData::class);
    }
}
