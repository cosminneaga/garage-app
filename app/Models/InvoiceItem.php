<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Support\Carbon;
use App\Enums\JobName;
use Database\Factories\InvoiceItemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property JobName $job_name
 * @property string $sku
 * @property int $quantity
 * @property numeric $item_price
 * @property numeric $labour_price
 * @property int $invoice_id
 * @property int $supplier_id
 * @property int $part_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Supplier|null $supplier
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
 * @method static Builder<static>|InvoiceItem whereItemPrice($value)
 * @method static Builder<static>|InvoiceItem whereJobName($value)
 * @method static Builder<static>|InvoiceItem whereLabourPrice($value)
 * @method static Builder<static>|InvoiceItem wherePartId($value)
 * @method static Builder<static>|InvoiceItem whereQuantity($value)
 * @method static Builder<static>|InvoiceItem whereSku($value)
 * @method static Builder<static>|InvoiceItem whereSupplierId($value)
 * @method static Builder<static>|InvoiceItem whereUpdatedAt($value)
 * @method static Builder<static>|InvoiceItem whereUpdatedBy($value)
 * @method static Builder<static>|InvoiceItem withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|InvoiceItem withoutTrashed()
 * @mixin \Eloquent
 */
#[Fillable([
    'job_name',
    'quantity',
    'item_price',
    'labour_price',
])]
class InvoiceItem extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $attributes = [
        'quantity' => 0,
        'item_price' => 0.00,
        'labour_price' => 0.00,
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    protected function casts(): array
    {
        return [
            'job_name' => JobName::class,
        ];
    }
}
