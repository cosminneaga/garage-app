<?php

namespace App\Models;

use App\Enums\Parts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairInvoiceItem extends Model
{
    /** @use HasFactory<RepairInvoiceItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'item_price',
        'labour_price',
    ];

    protected $casts = [
        'name' => Parts::class,
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
}
