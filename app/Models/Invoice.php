<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FormattedDateTime;
use App\Enums\PaymentMethod;
use App\Enums\Status\InvoiceStatus;
use App\Observers\InvoiceObserver;
use App\Traits\Blameable;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Override;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

/**
 * @property int $id
 * @property string $invoice_number
 * @property numeric $work_time
 * @property numeric $hourly_charge
 * @property InvoiceStatus $status
 * @property numeric $discount_applied
 * @property numeric $paid_amount
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activitiesAsSubject
 * @property-read int|null $activities_as_subject_count
 * @property-read Collection<int, InvoiceItem> $items
 * @property-read int|null $items_count
 * @method static InvoiceFactory factory($count = null, $state = [])
 * @method static Builder<static>|Invoice newModelQuery()
 * @method static Builder<static>|Invoice newQuery()
 * @method static Builder<static>|Invoice onlyTrashed()
 * @method static Builder<static>|Invoice query()
 * @method static Builder<static>|Invoice whereCreatedAt($value)
 * @method static Builder<static>|Invoice whereDeletedAt($value)
 * @method static Builder<static>|Invoice whereDescription($value)
 * @method static Builder<static>|Invoice whereDiscountApplied($value)
 * @method static Builder<static>|Invoice whereHourlyCharge($value)
 * @method static Builder<static>|Invoice whereId($value)
 * @method static Builder<static>|Invoice whereInvoiceNumber($value)
 * @method static Builder<static>|Invoice wherePaidAmount($value)
 * @method static Builder<static>|Invoice whereStatus($value)
 * @method static Builder<static>|Invoice whereUpdatedAt($value)
 * @method static Builder<static>|Invoice whereWorkTime($value)
 * @method static Builder<static>|Invoice withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Invoice withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperInvoice
 */
#[ObservedBy(InvoiceObserver::class)]
#[Fillable([
    'status',
    'due_date',
    'paid_at',
    'issued_at',
    'subtotal',
    'discount',
    'tax_amount',
    'total',
    'worked_minutes',
    'amount_due',
    'amount_paid',
    'payment_method',
    'notes'
])]
class Invoice extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;
    use Blameable;
    use Searchable;

    #[Override]
    protected static function booted(): void
    {
        static::created(function ($model) {
            $model->number = sprintf(
                '%s-%s-%010d',
                $model->company->invoice_prefix,
                Carbon::now()->format('dmY'),
                $model->id
            );
            $model->saveQuietly();
        });
    }

    protected $attributes = [
        'status' => InvoiceStatus::DRAFT->value,
        'payment_method' => PaymentMethod::OTHER->value,
        'subtotal' => 0.00,
        'discount' => 0.00,
        'tax_amount' => 0.00,
        'total' => 0.00,
        'worked_minutes' => 0,
        'amount_due' => 0.00,
        'amount_paid' => 0.00,
    ];

    protected function casts(): array
    {
        return [
            'status' => InvoiceStatus::class,
            'payment_method' => PaymentMethod::class,
            'due_date' => FormattedDateTime::class,
            'paid_at' => FormattedDateTime::class,
            'issued_at' => FormattedDateTime::class,
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total' => 'decimal:2',
            'worked_minutes' => 'integer',
            'amount_due' => 'decimal:2',
            'amount_paid' => 'decimal:2',
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'number' => $this->number,
            'status' => $this->status,
        ];
    }

    public function isLocked(): bool
    {
        return in_array($this->status, [
            InvoiceStatus::PAID,
            InvoiceStatus::CANCELLED,
            InvoiceStatus::ARCHIVED,
            InvoiceStatus::WRITTEN_OFF,
        ], true);
    }

    public function isPartOfMyCompany(User $user): bool
    {
        return (bool) $this->company->users()->find($user->id);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(InvoiceStatus::class);
    }
}
