<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property int $number
 * @property string $status
 * @property int|null $odometer_on_start
 * @property int|null $odometer_on_finish
 * @property string|null $complaint
 * @property string|null $initial_inspection_notes
 * @property string|null $notes
 * @property string|null $part_notes
 * @property numeric $labour_price_hourly
 * @property numeric $labour_total_cost
 * @property numeric $part_total_cost
 * @property int $technician_id
 * @property int $booking_id
 * @property int $company_id
 * @property int $assigned_by
 * @property int $vehicle_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @method static Builder<static>|Workorder newModelQuery()
 * @method static Builder<static>|Workorder newQuery()
 * @method static Builder<static>|Workorder onlyTrashed()
 * @method static Builder<static>|Workorder query()
 * @method static Builder<static>|Workorder whereAssignedBy($value)
 * @method static Builder<static>|Workorder whereBookingId($value)
 * @method static Builder<static>|Workorder whereCompanyId($value)
 * @method static Builder<static>|Workorder whereComplaint($value)
 * @method static Builder<static>|Workorder whereCreatedAt($value)
 * @method static Builder<static>|Workorder whereCreatedBy($value)
 * @method static Builder<static>|Workorder whereDeletedAt($value)
 * @method static Builder<static>|Workorder whereId($value)
 * @method static Builder<static>|Workorder whereInitialInspectionNotes($value)
 * @method static Builder<static>|Workorder whereLabourPriceHourly($value)
 * @method static Builder<static>|Workorder whereLabourTotalCost($value)
 * @method static Builder<static>|Workorder whereNotes($value)
 * @method static Builder<static>|Workorder whereNumber($value)
 * @method static Builder<static>|Workorder whereOdometerOnFinish($value)
 * @method static Builder<static>|Workorder whereOdometerOnStart($value)
 * @method static Builder<static>|Workorder wherePartNotes($value)
 * @method static Builder<static>|Workorder wherePartTotalCost($value)
 * @method static Builder<static>|Workorder whereStatus($value)
 * @method static Builder<static>|Workorder whereTechnicianId($value)
 * @method static Builder<static>|Workorder whereTitle($value)
 * @method static Builder<static>|Workorder whereUpdatedAt($value)
 * @method static Builder<static>|Workorder whereUpdatedBy($value)
 * @method static Builder<static>|Workorder whereVehicleId($value)
 * @method static Builder<static>|Workorder withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Workorder withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperWorkorder
 */
class Workorder extends Model
{
    use SoftDeletes;
    use Blameable;
}
