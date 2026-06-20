<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Database\Factories\RepairInvoiceItemFactory;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\JobName;
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
 * @property int $repair_invoice_id
 * @property int $supplier_id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read RepairInvoice|null $invoice
 * @property-read Product|null $product
 * @property-read Supplier|null $supplier
 * @method static RepairInvoiceItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|RepairInvoiceItem newModelQuery()
 * @method static Builder<static>|RepairInvoiceItem newQuery()
 * @method static Builder<static>|RepairInvoiceItem onlyTrashed()
 * @method static Builder<static>|RepairInvoiceItem query()
 * @method static Builder<static>|RepairInvoiceItem whereCreatedAt($value)
 * @method static Builder<static>|RepairInvoiceItem whereDeletedAt($value)
 * @method static Builder<static>|RepairInvoiceItem whereId($value)
 * @method static Builder<static>|RepairInvoiceItem whereItemPrice($value)
 * @method static Builder<static>|RepairInvoiceItem whereJobName($value)
 * @method static Builder<static>|RepairInvoiceItem whereLabourPrice($value)
 * @method static Builder<static>|RepairInvoiceItem whereProductId($value)
 * @method static Builder<static>|RepairInvoiceItem whereQuantity($value)
 * @method static Builder<static>|RepairInvoiceItem whereRepairInvoiceId($value)
 * @method static Builder<static>|RepairInvoiceItem whereSku($value)
 * @method static Builder<static>|RepairInvoiceItem whereSupplierId($value)
 * @method static Builder<static>|RepairInvoiceItem whereUpdatedAt($value)
 * @method static Builder<static>|RepairInvoiceItem withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|RepairInvoiceItem withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperRepairInvoiceItem
 */
class RepairInvoiceItem extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'job_name',
        'quantity',
        'item_price',
        'labour_price',
    ];

    protected $casts = [
        'job_name' => JobName::class,
    ];

    protected $attributes = [
        'quantity' => 0,
        'item_price' => 0.00,
        'labour_price' => 0.00,
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(RepairInvoice::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
