<?php

declare(strict_types=1);

namespace App\Enums\Status;

use App\Traits\HasEnumOptions;

enum InvoiceStatus: string
{
    use HasEnumOptions;

    case DRAFT = 'draft';                               # auto set on create without due_date
    case PENDING = 'pending';                           # auto set on create with due_date
    case ISSUED = 'issued';                             # due_date set
    case PAID = 'paid';                                 # amount_paid set
    case PAID_PARTIALLY = 'paid_partially';             # amount_paid set
    case REFUNDED = 'refunded';                         # amount set to 0.00 from total
    case REFUNDED_PARTIALLY = 'refunded_partially';     # amount set to lower than previous total but greater than 0.00
    case FAILED_PAYMENT = 'failed_payment';             # payment system failure
    case OVERDUE = 'overdue';                           # background job action
    case CANCELLED = 'cancelled';                       # manual set
    case DISPUTED = 'disputed';                         # manual set
    case WRITTEN_OFF = 'written_off';                   # manual set
    case ARCHIVED = 'archived';                         # manual set

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::ISSUED => 'Issued / Sent',
            self::PAID => 'Paid',
            self::PAID_PARTIALLY => 'Paid Partially',
            self::REFUNDED => 'Refunded',
            self::REFUNDED_PARTIALLY => 'Refunded Partially',
            self::FAILED_PAYMENT => 'Payment Attempt Failed',
            self::OVERDUE => 'Overdue',
            self::CANCELLED => 'Cancelled',
            self::DISPUTED => 'Invoice Disputed by Client',
            self::WRITTEN_OFF => 'Written Off',
            self::ARCHIVED => 'Archived Invoice',
        };
    }
}
