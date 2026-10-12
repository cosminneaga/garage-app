<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status\BookingStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property string $status
 * @property string|null $description
 * @property int $booking_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Booking|null $booking
 * @method static Builder<static>|BookingStatusHistory newModelQuery()
 * @method static Builder<static>|BookingStatusHistory newQuery()
 * @method static Builder<static>|BookingStatusHistory onlyTrashed()
 * @method static Builder<static>|BookingStatusHistory query()
 * @method static Builder<static>|BookingStatusHistory whereBookingId($value)
 * @method static Builder<static>|BookingStatusHistory whereCreatedAt($value)
 * @method static Builder<static>|BookingStatusHistory whereDescription($value)
 * @method static Builder<static>|BookingStatusHistory whereId($value)
 * @method static Builder<static>|BookingStatusHistory whereStatus($value)
 * @method static Builder<static>|BookingStatusHistory whereUpdatedAt($value)
 * @method static Builder<static>|BookingStatusHistory withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|BookingStatusHistory withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperBookingStatusHistory
 */
#[Fillable([
    'status',
    'description',
])]
class BookingStatusHistory extends Model
{
    protected $attributes = [
        'status' => BookingStatus::PENDING->value,
    ];

    protected function casts(): array
    {
        return [
            'status' => BookingStatus::class,
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
