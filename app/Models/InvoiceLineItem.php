<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Type\WorkorderOperationType;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property WorkorderOperationType $type
 * @property int $worked_minutes
 * @property int|null $part_id
 * @property numeric $total_cost
 * @property int $invoice_item_id
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
 * @property-read \App\Models\InvoiceItem|null $item
 * @property-read \App\Models\Part|null $part
 * @property-read Model|\Eloquent|null $updatedByActor
 * @property-read \App\Models\User|null $updater
 * @method static Builder<static>|InvoiceLineItem newModelQuery()
 * @method static Builder<static>|InvoiceLineItem newQuery()
 * @method static Builder<static>|InvoiceLineItem onlyTrashed()
 * @method static Builder<static>|InvoiceLineItem query()
 * @method static Builder<static>|InvoiceLineItem whereCreatedAt($value)
 * @method static Builder<static>|InvoiceLineItem whereCreatedBy($value)
 * @method static Builder<static>|InvoiceLineItem whereDeletedAt($value)
 * @method static Builder<static>|InvoiceLineItem whereDeletedBy($value)
 * @method static Builder<static>|InvoiceLineItem whereId($value)
 * @method static Builder<static>|InvoiceLineItem whereInvoiceItemId($value)
 * @method static Builder<static>|InvoiceLineItem wherePartId($value)
 * @method static Builder<static>|InvoiceLineItem whereTotalCost($value)
 * @method static Builder<static>|InvoiceLineItem whereType($value)
 * @method static Builder<static>|InvoiceLineItem whereUpdatedAt($value)
 * @method static Builder<static>|InvoiceLineItem whereUpdatedBy($value)
 * @method static Builder<static>|InvoiceLineItem whereWorkedMinutes($value)
 * @method static Builder<static>|InvoiceLineItem withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|InvoiceLineItem withoutTrashed()
 * @mixin \Eloquent
 */
#[Fillable(
    'type',
    'worked_minutes',
    'total_cost',
    'part_id',
    'invoice_item_id',
)]
class InvoiceLineItem extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Blameable;

    protected $attributes = [
        'type' => WorkorderOperationType::OTHER->value,
        'worked_minutes' => 0,
        'total_cost' => 0.00,
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'type' => WorkorderOperationType::class,
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(InvoiceItem::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}
