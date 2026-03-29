<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JobName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairInvoiceItem extends Model
{
    /** @use HasFactory<RepairInvoiceItemFactory> */
    use HasFactory, SoftDeletes;

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
