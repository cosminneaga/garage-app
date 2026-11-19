<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JobName;
use App\Traits\Blameable;
use Database\Factories\InvoiceItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
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
 * @property JobName $job_name
 * @property string $workorder_number
 * @property int|null $odometer_on_start
 * @property int|null $odometer_on_finish
 * @property int $worked_minutes
 * @property numeric $labour_rate
 * @property numeric $total_cost
 * @property int $invoice_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Model|\Eloquent|null $createdByActor
 * @property-read \App\Models\User|null $creator
 * @property-read Model|\Eloquent|null $deletedByActor
 * @property-read \App\Models\User|null $deletor
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read Collection<int, \App\Models\InvoiceLineItem> $lineItems
 * @property-read int|null $line_items_count
 * @property-read Model|\Eloquent|null $updatedByActor
 * @property-read \App\Models\User|null $updater
 * @method static \Database\Factories\InvoiceItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|InvoiceItem newModelQuery()
 * @method static Builder<static>|InvoiceItem newQuery()
 * @method static Builder<static>|InvoiceItem onlyTrashed()
 * @method static Builder<static>|InvoiceItem query()
 * @method static Builder<static>|InvoiceItem whereCreatedAt($value)
 * @method static Builder<static>|InvoiceItem whereCreatedBy($value)
 * @method static Builder<static>|InvoiceItem whereDeletedAt($value)
 * @method static Builder<static>|InvoiceItem whereDeletedBy($value)
 * @method static Builder<static>|InvoiceItem whereId($value)
 * @method static Builder<static>|InvoiceItem whereInvoiceId($value)
 * @method static Builder<static>|InvoiceItem whereJobName($value)
 * @method static Builder<static>|InvoiceItem whereLabourRate($value)
 * @method static Builder<static>|InvoiceItem whereOdometerOnFinish($value)
 * @method static Builder<static>|InvoiceItem whereOdometerOnStart($value)
 * @method static Builder<static>|InvoiceItem whereTotalCost($value)
 * @method static Builder<static>|InvoiceItem whereUpdatedAt($value)
 * @method static Builder<static>|InvoiceItem whereUpdatedBy($value)
 * @method static Builder<static>|InvoiceItem whereWorkedMinutes($value)
 * @method static Builder<static>|InvoiceItem whereWorkorderNumber($value)
 * @method static Builder<static>|InvoiceItem withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|InvoiceItem withoutTrashed()
 * @mixin \Eloquent
 */
#[Fillable([
    'job_name',
    'workorder_number',
    'odometer_on_start',
    'odometer_on_finish',
    'worked_minutes',
    'labour_rate',
    'total_cost',
    'invoice_id',
])]
class InvoiceItem extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Blameable;

    protected $attributes = [
        'job_name' => JobName::OIL_CHANGE->value,
        'worked_minutes' => 0,
        'labour_rate' => 0.00,
        'total_cost' => 0.00,
    ];

    protected function casts(): array
    {
        return [
            'job_name' => JobName::class,
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(InvoiceLineItem::class);
    }
}
