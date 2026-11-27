<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Status\InvoiceStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property InvoiceStatus $status
 * @property string|null $description
 * @property int $invoice_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Invoice|null $invoice
 * @method static Builder<static>|InvoiceStatusHistory newModelQuery()
 * @method static Builder<static>|InvoiceStatusHistory newQuery()
 * @method static Builder<static>|InvoiceStatusHistory query()
 * @method static Builder<static>|InvoiceStatusHistory whereCreatedAt($value)
 * @method static Builder<static>|InvoiceStatusHistory whereDescription($value)
 * @method static Builder<static>|InvoiceStatusHistory whereId($value)
 * @method static Builder<static>|InvoiceStatusHistory whereInvoiceId($value)
 * @method static Builder<static>|InvoiceStatusHistory whereStatus($value)
 * @method static Builder<static>|InvoiceStatusHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(
    'status',
    'description',
)]
#[Table(name: 'invoice_status_history')]
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
