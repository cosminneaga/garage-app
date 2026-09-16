<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status\VehicleStatus;
use App\Enums\Type\FuelType;
use App\Policies\VehiclePolicy;
use App\Traits\Blameable;
use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $vin
 * @property string|null $registration
 * @property FuelType $fuel
 * @property VehicleStatus $status
 * @property int|null $first_visit_odometer
 * @property string|null $first_registration
 * @property Carbon|null $first_visit
 * @property string|null $technical_notes
 * @property string|null $notes
 * @property string|null $diagnostic_information
 * @property int|null $make_id
 * @property int|null $model_id
 * @property int|null $data_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\Models\Company|null $companies
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\VehicleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Vehicle newModelQuery()
 * @method static Builder<static>|Vehicle newQuery()
 * @method static Builder<static>|Vehicle onlyTrashed()
 * @method static Builder<static>|Vehicle query()
 * @method static Builder<static>|Vehicle whereCreatedAt($value)
 * @method static Builder<static>|Vehicle whereCreatedBy($value)
 * @method static Builder<static>|Vehicle whereDataId($value)
 * @method static Builder<static>|Vehicle whereDeletedAt($value)
 * @method static Builder<static>|Vehicle whereDeletedBy($value)
 * @method static Builder<static>|Vehicle whereDiagnosticInformation($value)
 * @method static Builder<static>|Vehicle whereFirstRegistration($value)
 * @method static Builder<static>|Vehicle whereFirstVisit($value)
 * @method static Builder<static>|Vehicle whereFirstVisitOdometer($value)
 * @method static Builder<static>|Vehicle whereFuel($value)
 * @method static Builder<static>|Vehicle whereId($value)
 * @method static Builder<static>|Vehicle whereMakeId($value)
 * @method static Builder<static>|Vehicle whereModelId($value)
 * @method static Builder<static>|Vehicle whereNotes($value)
 * @method static Builder<static>|Vehicle whereRegistration($value)
 * @method static Builder<static>|Vehicle whereStatus($value)
 * @method static Builder<static>|Vehicle whereTechnicalNotes($value)
 * @method static Builder<static>|Vehicle whereUpdatedAt($value)
 * @method static Builder<static>|Vehicle whereUpdatedBy($value)
 * @method static Builder<static>|Vehicle whereVin($value)
 * @method static Builder<static>|Vehicle withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Vehicle withoutTrashed()
 * @mixin \Eloquent
 */

#[UsePolicy(VehiclePolicy::class)]
class Vehicle extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'vin',
        'registration',
        'fuel',
        'status',
        'first_visit_odometer',
        'first_registration',
        'first_visit',
        'technical_notes',
        'notes',
        'diagnostic_information',
        'make_id',
        'model_id',
        'data_id',
    ];

    protected $casts = [
        'fuel' => FuelType::class,
        'status' => VehicleStatus::class,
        'first_visit' => 'datetime',
    ];

    protected $attributes = [
        'fuel' => FuelType::OTHER->value,
        'status' => VehicleStatus::ACTIVE->value,
    ];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
