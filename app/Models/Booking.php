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
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $number
 * @property string $status
 * @property string $service_type
 * @property string $priority
 * @property string|null $appointment_start
 * @property string|null $appointment_finish
 * @property string|null $reminder_sent_at
 * @property string|null $checked_in_at
 * @property string|null $completed_at
 * @property string|null $cancelled_at
 * @property int|null $estimated_duration
 * @property string|null $status_info
 * @property string|null $complaint
 * @property string|null $notes
 * @property string|null $client_notes
 * @property numeric $estimated_cost
 * @property int $client_id
 * @property int $vehicle_id
 * @property int $company_id
 * @property int $advisor_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read User|null $creator
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $updater
 * @method static BookingFactory factory($count = null, $state = [])
 * @method static Builder<static>|Booking newModelQuery()
 * @method static Builder<static>|Booking newQuery()
 * @method static Builder<static>|Booking onlyTrashed()
 * @method static Builder<static>|Booking query()
 * @method static Builder<static>|Booking whereAdvisorId($value)
 * @method static Builder<static>|Booking whereAppointmentFinish($value)
 * @method static Builder<static>|Booking whereAppointmentStart($value)
 * @method static Builder<static>|Booking whereCancelledAt($value)
 * @method static Builder<static>|Booking whereCheckedInAt($value)
 * @method static Builder<static>|Booking whereClientId($value)
 * @method static Builder<static>|Booking whereClientNotes($value)
 * @method static Builder<static>|Booking whereCompanyId($value)
 * @method static Builder<static>|Booking whereComplaint($value)
 * @method static Builder<static>|Booking whereCompletedAt($value)
 * @method static Builder<static>|Booking whereCreatedAt($value)
 * @method static Builder<static>|Booking whereCreatedBy($value)
 * @method static Builder<static>|Booking whereDeletedAt($value)
 * @method static Builder<static>|Booking whereEstimatedCost($value)
 * @method static Builder<static>|Booking whereEstimatedDuration($value)
 * @method static Builder<static>|Booking whereId($value)
 * @method static Builder<static>|Booking whereNotes($value)
 * @method static Builder<static>|Booking whereNumber($value)
 * @method static Builder<static>|Booking wherePriority($value)
 * @method static Builder<static>|Booking whereReminderSentAt($value)
 * @method static Builder<static>|Booking whereServiceType($value)
 * @method static Builder<static>|Booking whereStatus($value)
 * @method static Builder<static>|Booking whereStatusInfo($value)
 * @method static Builder<static>|Booking whereUpdatedAt($value)
 * @method static Builder<static>|Booking whereUpdatedBy($value)
 * @method static Builder<static>|Booking whereVehicleId($value)
 * @method static Builder<static>|Booking withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Booking withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperBooking
 */
class Booking extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use LogsActivity;

    protected $fillable = [
        'notes',
        'on',
    ];

    protected $casts = [
        'on' => 'datetime',
    ];
}
