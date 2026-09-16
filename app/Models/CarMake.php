<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CarModel> $models
 * @property-read int|null $models_count
 * @method static \Database\Factories\CarMakeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarMake newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarMake newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarMake query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarMake whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarMake whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarMake whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CarMake whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarMake extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'name',
    ];

    public function models(): HasMany
    {
        return $this->hasMany(CarModel::class, 'make_id');
    }
}
