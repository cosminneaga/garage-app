<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status\InvoiceStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperInvoiceStatusHistory
 */
#[Fillable(
    'status',
    'description',
)]
class InvoiceStatusHistory extends Model
{
    protected $attributes = [
        'status' => InvoiceStatus::DRAFT->value,
    ];

    protected function casts()
    {
        return [
            'status' => InvoiceStatus::class,
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
