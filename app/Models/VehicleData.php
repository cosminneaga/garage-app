<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property int $cylinders
 * @property float $displacement
 * @property string $drive
 * @property string $transmission
 * @property int $vehicle_make_id
 * @property int $vehicle_model_id
 * @property int $vehicle_year_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\VehicleMake|null $make
 * @property-read \App\Models\VehicleModel|null $model
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Repair> $repairs
 * @property-read int|null $repairs_count
 * @property-read \App\Models\VehicleYear|null $year
 * @method static \Database\Factories\VehicleDataFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereCylinders($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereDisplacement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereDrive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereTransmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereVehicleMakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereVehicleModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData whereVehicleYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VehicleData withoutTrashed()
 * @mixin \Eloquent
 */
class VehicleData extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'cylinders',
        'displacement',
        'drive',
        'transmission',
    ];

    protected $casts = [
        'displacement' => 'float',
    ];

    public function make(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(VehicleYear::class);
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }
}
