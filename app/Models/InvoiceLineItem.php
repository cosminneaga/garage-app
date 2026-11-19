<?php

declare(strict_types=1);

namespace App\Models;

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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Model|\Eloquent|null $createdByActor
 * @property-read \App\Models\User|null $creator
 * @property-read Model|\Eloquent|null $deletedByActor
 * @property-read \App\Models\User|null $deletor
 * @property-read \App\Models\InvoiceItem|null $item
 * @property-read \App\Models\Part|null $part
 * @property-read Model|\Eloquent|null $updatedByActor
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereInvoiceItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem wherePartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem whereWorkedMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceLineItem withoutTrashed()
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
