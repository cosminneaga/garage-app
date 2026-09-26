<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Database\Factories\CarModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $name
 * @property string $class
 * @property int $make_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\CarMake $make
 * @method static \Database\Factories\CarModelFactory factory($count = null, $state = [])
 * @method static Builder<static>|CarModel newModelQuery()
 * @method static Builder<static>|CarModel newQuery()
 * @method static Builder<static>|CarModel query()
 * @method static Builder<static>|CarModel whereClass($value)
 * @method static Builder<static>|CarModel whereCreatedAt($value)
 * @method static Builder<static>|CarModel whereId($value)
 * @method static Builder<static>|CarModel whereMakeId($value)
 * @method static Builder<static>|CarModel whereName($value)
 * @method static Builder<static>|CarModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarModel extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [];

    public function make(): BelongsTo
    {
        return $this->belongsTo(CarMake::class);
    }
}
