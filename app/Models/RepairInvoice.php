<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\RepairInvoiceFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\InvoiceStatus;
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
 * @property string $invoice_number
 * @property numeric $work_time
 * @property numeric $hourly_charge
 * @property InvoiceStatus $status
 * @property numeric $discount_applied
 * @property numeric $paid_amount
 * @property string|null $description
 * @property int $repair_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, RepairInvoiceItem> $items
 * @property-read int|null $items_count
 * @property-read Repair|null $repair
 * @method static RepairInvoiceFactory factory($count = null, $state = [])
 * @method static Builder<static>|RepairInvoice newModelQuery()
 * @method static Builder<static>|RepairInvoice newQuery()
 * @method static Builder<static>|RepairInvoice onlyTrashed()
 * @method static Builder<static>|RepairInvoice query()
 * @method static Builder<static>|RepairInvoice whereCreatedAt($value)
 * @method static Builder<static>|RepairInvoice whereDeletedAt($value)
 * @method static Builder<static>|RepairInvoice whereDescription($value)
 * @method static Builder<static>|RepairInvoice whereDiscountApplied($value)
 * @method static Builder<static>|RepairInvoice whereHourlyCharge($value)
 * @method static Builder<static>|RepairInvoice whereId($value)
 * @method static Builder<static>|RepairInvoice whereInvoiceNumber($value)
 * @method static Builder<static>|RepairInvoice wherePaidAmount($value)
 * @method static Builder<static>|RepairInvoice whereRepairId($value)
 * @method static Builder<static>|RepairInvoice whereStatus($value)
 * @method static Builder<static>|RepairInvoice whereUpdatedAt($value)
 * @method static Builder<static>|RepairInvoice whereWorkTime($value)
 * @method static Builder<static>|RepairInvoice withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|RepairInvoice withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperRepairInvoice
 */
class RepairInvoice extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'work_time',
        'hourly_charge',
        'status',
        'discount_applied',
        'paid_amount',
    ];

    protected $casts = [
        'status' => InvoiceStatus::class,
    ];

    protected $attributes = [
        'status' => InvoiceStatus::DRAFT->value,
        'discount_applied' => 0.00,
        'paid_amount' => 0.00,
    ];

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(RepairInvoiceItem::class);
    }
}
