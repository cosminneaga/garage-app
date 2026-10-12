<?php

declare(strict_types=1);

namespace App\Enums\Status;

use App\Traits\HasEnumOptions;

enum InvoiceStatus: string
{
    use HasEnumOptions;

    case DRAFT = 'draft';                       # auto set on create
    case ISSUED = 'issued';                     # due_date set
    case PAID = 'paid';                         # amount_paid set
    case PAID_PARTIALLY = 'paid_partially';     # amount_paid set
    case PENDING = 'pending';                   # manually set on approval
    case OVERDUE = 'overdue';                   # background job action
    case CANCELLED = 'cancelled';               # manual set
    case REFUNDED = 'refunded';                 # amount set to 0.00 from value
    case FAILED_PAYMENT = 'failed_payment';     # payment system failure
    case DISPUTED = 'disputed';                 # manual set
    case WRITTEN_OFF = 'written_off';           # manual set
    case ARCHIVED = 'archived';                 # manual set

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ISSUED => 'Issued / Sent',
            self::PAID => 'Paid',
            self::PAID_PARTIALLY => 'Paid Partially',
            self::PENDING => 'Pending',
            self::OVERDUE => 'Overdue',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
            self::FAILED_PAYMENT => 'Payment Attempt Failed',
            self::DISPUTED => 'Invoice Disputed by Client',
            self::WRITTEN_OFF => 'Written Off',
            self::ARCHIVED => 'Archived Invoice',
        };
    }
}
