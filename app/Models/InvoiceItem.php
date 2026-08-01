<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\InvoiceItemFactory;
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
 * @property JobName $job_name
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Invoice|null $invoice
 * @property-read Product|null $product
 * @property-read Supplier|null $supplier
 * @method static InvoiceItemFactory factory($count = null, $state = [])
 * @method static Builder<static>|InvoiceItem newModelQuery()
 * @method static Builder<static>|InvoiceItem newQuery()
 * @method static Builder<static>|InvoiceItem onlyTrashed()
 * @method static Builder<static>|InvoiceItem query()
 * @method static Builder<static>|InvoiceItem withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|InvoiceItem withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperInvoiceItem
 */
class InvoiceItem extends Model
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
        return $this->belongsTo(Invoice::class);
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
