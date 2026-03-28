<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairInvoice extends Model
{
    /** @use HasFactory<RepairInvoiceFactory> */
    use HasFactory, SoftDeletes;

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
