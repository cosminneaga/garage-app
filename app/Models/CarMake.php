<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Database\Factories\CarMakeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, CarModel> $models
 * @property-read int|null $models_count
 * @method static CarMakeFactory factory($count = null, $state = [])
 * @method static Builder<static>|CarMake newModelQuery()
 * @method static Builder<static>|CarMake newQuery()
 * @method static Builder<static>|CarMake query()
 * @method static Builder<static>|CarMake whereCreatedAt($value)
 * @method static Builder<static>|CarMake whereId($value)
 * @method static Builder<static>|CarMake whereName($value)
 * @method static Builder<static>|CarMake whereUpdatedAt($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCarMake
 */
#[Fillable([
    'name',
])]
class CarMake extends Model
{
    use HasFactory;
    use LogsActivity;

    public function models(): HasMany
    {
        return $this->hasMany(CarModel::class, 'make_id');
    }
}
