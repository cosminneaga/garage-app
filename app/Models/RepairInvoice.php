<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InvoiceStatus;
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
 * @property-read Collection<int, \App\Models\RepairInvoiceItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Repair|null $repair
 * @method static \Database\Factories\RepairInvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereDiscountApplied($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereHourlyCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereRepairId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice whereWorkTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RepairInvoice withoutTrashed()
 * @mixin \Eloquent
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
