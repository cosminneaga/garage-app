<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\RepairFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\FuelType;
use App\Enums\RepairStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $registration
 * @property string $vin
 * @property int $odometer
 * @property FuelType $fuel
 * @property RepairStatus $status
 * @property string|null $complaint_description
 * @property string|null $initial_inspection
 * @property string|null $diagnosis_notes
 * @property string|null $work_order
 * @property string|null $parts_required
 * @property string|null $execution_data
 * @property string|null $labour_tracking_data
 * @property string|null $quality_check_testing
 * @property string|null $service_record
 * @property int $booking_id
 * @property int $vehicle_data_id
 * @property int $company_id
 * @property int $client_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Booking|null $booking
 * @property-read Client|null $client
 * @property-read Company|null $company
 * @property-read VehicleData|null $data
 * @property-read Collection<int, RepairFile> $files
 * @property-read int|null $files_count
 * @property-read Collection<int, RepairInvoice> $invoices
 * @property-read int|null $invoices_count
 * @method static RepairFactory factory($count = null, $state = [])
 * @method static Builder<static>|Repair newModelQuery()
 * @method static Builder<static>|Repair newQuery()
 * @method static Builder<static>|Repair onlyTrashed()
 * @method static Builder<static>|Repair query()
 * @method static Builder<static>|Repair whereBookingId($value)
 * @method static Builder<static>|Repair whereClientId($value)
 * @method static Builder<static>|Repair whereCompanyId($value)
 * @method static Builder<static>|Repair whereComplaintDescription($value)
 * @method static Builder<static>|Repair whereCreatedAt($value)
 * @method static Builder<static>|Repair whereDeletedAt($value)
 * @method static Builder<static>|Repair whereDiagnosisNotes($value)
 * @method static Builder<static>|Repair whereExecutionData($value)
 * @method static Builder<static>|Repair whereFuel($value)
 * @method static Builder<static>|Repair whereId($value)
 * @method static Builder<static>|Repair whereInitialInspection($value)
 * @method static Builder<static>|Repair whereLabourTrackingData($value)
 * @method static Builder<static>|Repair whereOdometer($value)
 * @method static Builder<static>|Repair wherePartsRequired($value)
 * @method static Builder<static>|Repair whereQualityCheckTesting($value)
 * @method static Builder<static>|Repair whereRegistration($value)
 * @method static Builder<static>|Repair whereServiceRecord($value)
 * @method static Builder<static>|Repair whereStatus($value)
 * @method static Builder<static>|Repair whereUpdatedAt($value)
 * @method static Builder<static>|Repair whereVehicleDataId($value)
 * @method static Builder<static>|Repair whereVin($value)
 * @method static Builder<static>|Repair whereWorkOrder($value)
 * @method static Builder<static>|Repair withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Repair withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperRepair
 */
class Repair extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [];

    protected $casts = [
        'status' => RepairStatus::class,
        'fuel' => FuelType::class,
    ];

    protected $attributes = [
        'status' => RepairStatus::RECEPTION->value,
        'fuel' => FuelType::OTHER->value,
    ];

    public function files(): HasMany
    {
        return $this->hasMany(RepairFile::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(RepairInvoice::class);
    }

    public function data(): BelongsTo
    {
        return $this->belongsTo(VehicleData::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
