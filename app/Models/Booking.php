<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Blameable;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string|null $notes
 * @property Carbon $on
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, Repair> $repairs
 * @property-read int|null $repairs_count
 * @method static BookingFactory factory($count = null, $state = [])
 * @method static Builder<static>|Booking newModelQuery()
 * @method static Builder<static>|Booking newQuery()
 * @method static Builder<static>|Booking onlyTrashed()
 * @method static Builder<static>|Booking query()
 * @method static Builder<static>|Booking whereCreatedAt($value)
 * @method static Builder<static>|Booking whereDeletedAt($value)
 * @method static Builder<static>|Booking whereId($value)
 * @method static Builder<static>|Booking whereNotes($value)
 * @method static Builder<static>|Booking whereOn($value)
 * @method static Builder<static>|Booking whereUpdatedAt($value)
 * @method static Builder<static>|Booking withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Booking withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperBooking
 */
class Booking extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Blameable;

    protected $fillable = [
        'notes',
        'on',
    ];

    protected $casts = [
        'on' => 'datetime',
    ];
}
