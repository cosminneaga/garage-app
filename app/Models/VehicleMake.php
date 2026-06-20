<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\VehicleMakeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, VehicleData> $data
 * @property-read int|null $data_count
 * @property-read Collection<int, VehicleModel> $models
 * @property-read int|null $models_count
 * @method static VehicleMakeFactory factory($count = null, $state = [])
 * @method static Builder<static>|VehicleMake newModelQuery()
 * @method static Builder<static>|VehicleMake newQuery()
 * @method static Builder<static>|VehicleMake onlyTrashed()
 * @method static Builder<static>|VehicleMake query()
 * @method static Builder<static>|VehicleMake whereCreatedAt($value)
 * @method static Builder<static>|VehicleMake whereId($value)
 * @method static Builder<static>|VehicleMake whereName($value)
 * @method static Builder<static>|VehicleMake whereUpdatedAt($value)
 * @method static Builder<static>|VehicleMake withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|VehicleMake withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperVehicleMake
 */
class VehicleMake extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

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
