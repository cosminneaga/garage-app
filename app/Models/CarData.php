<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Database\Factories\CarDataFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property int $cylinders
 * @property float $displacement
 * @property string $drive
 * @property string $transmission
 * @property int $make_id
 * @property int $model_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @method static CarDataFactory factory($count = null, $state = [])
 * @method static Builder<static>|CarData newModelQuery()
 * @method static Builder<static>|CarData newQuery()
 * @method static Builder<static>|CarData query()
 * @method static Builder<static>|CarData whereCreatedAt($value)
 * @method static Builder<static>|CarData whereCylinders($value)
 * @method static Builder<static>|CarData whereDisplacement($value)
 * @method static Builder<static>|CarData whereDrive($value)
 * @method static Builder<static>|CarData whereId($value)
 * @method static Builder<static>|CarData whereMakeId($value)
 * @method static Builder<static>|CarData whereModelId($value)
 * @method static Builder<static>|CarData whereName($value)
 * @method static Builder<static>|CarData whereTransmission($value)
 * @method static Builder<static>|CarData whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCarData
 */
#[Fillable([
    'name',
    'cylinders',
    'displacement',
    'drive',
    'transmission',
])]
class CarData extends Model
{
    use HasFactory;
    use LogsActivity;
    protected function casts(): array
    {
        return [
            'displacement' => 'float',
        ];
    }
}
