<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InvoiceStatus;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property InvoiceStatus $status
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, InvoiceItem> $items
 * @property-read int|null $items_count
 * @property-read Repair|null $repair
 * @method static InvoiceFactory factory($count = null, $state = [])
 * @method static Builder<static>|Invoice newModelQuery()
 * @method static Builder<static>|Invoice newQuery()
 * @method static Builder<static>|Invoice onlyTrashed()
 * @method static Builder<static>|Invoice query()
 * @method static Builder<static>|Invoice withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Invoice withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperInvoice
 */
class Invoice extends Model
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

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
