<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\Type\TransactionType;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @mixin IdeHelperInvoiceTransaction
 */
#[Fillable([
    'method',
    'type',
    'value',
    'invoice_id',
])]
class InvoiceTransaction extends Model
{
    use LogsActivity;
    use SoftDeletes;
    use Blameable;
    use Searchable;

    protected $attributes = [
        'method' => PaymentMethod::OTHER->value,
        'type' => TransactionType::PAYMENT->value,
        'value' => 0.00,
    ];

    protected function casts(): array
    {
        return [
            'method' => PaymentMethod::class,
            'type' => TransactionType::class,
            'value' => 'decimal:2',
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'method' => $this->method,
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
