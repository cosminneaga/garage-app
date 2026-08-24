<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $vin
 * @property string|null $registration
 * @property string $fuel
 * @property string $status
 * @property int|null $first_visit_odometer
 * @property string|null $first_registration
 * @property string|null $first_visit
 * @property string|null $technical_notes
 * @property string|null $notes
 * @property string|null $diagnostic_information
 * @property int|null $vehicle_make_id
 * @property int|null $vehicle_model_id
 * @property int|null $vehicle_data_id
 * @property int|null $vehicle_year_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @method static VehicleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Vehicle newModelQuery()
 * @method static Builder<static>|Vehicle newQuery()
 * @method static Builder<static>|Vehicle onlyTrashed()
 * @method static Builder<static>|Vehicle query()
 * @method static Builder<static>|Vehicle whereCreatedAt($value)
 * @method static Builder<static>|Vehicle whereCreatedBy($value)
 * @method static Builder<static>|Vehicle whereDeletedAt($value)
 * @method static Builder<static>|Vehicle whereDiagnosticInformation($value)
 * @method static Builder<static>|Vehicle whereFirstRegistration($value)
 * @method static Builder<static>|Vehicle whereFirstVisit($value)
 * @method static Builder<static>|Vehicle whereFirstVisitOdometer($value)
 * @method static Builder<static>|Vehicle whereFuel($value)
 * @method static Builder<static>|Vehicle whereId($value)
 * @method static Builder<static>|Vehicle whereNotes($value)
 * @method static Builder<static>|Vehicle whereRegistration($value)
 * @method static Builder<static>|Vehicle whereStatus($value)
 * @method static Builder<static>|Vehicle whereTechnicalNotes($value)
 * @method static Builder<static>|Vehicle whereUpdatedAt($value)
 * @method static Builder<static>|Vehicle whereUpdatedBy($value)
 * @method static Builder<static>|Vehicle whereVehicleDataId($value)
 * @method static Builder<static>|Vehicle whereVehicleMakeId($value)
 * @method static Builder<static>|Vehicle whereVehicleModelId($value)
 * @method static Builder<static>|Vehicle whereVehicleYearId($value)
 * @method static Builder<static>|Vehicle whereVin($value)
 * @method static Builder<static>|Vehicle withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Vehicle withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperVehicle
 */
class Vehicle extends Model
{
    use Blameable;
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
}
