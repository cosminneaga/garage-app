<?php

namespace App;

enum InvoiceStatus: string
{
    case DRAFT = 'draft';
    case ISSUED = 'issued';
    case PENDING = 'pending';
    case PAID = 'paid';
    case PAID_PARTIALLY = 'paid_partially';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';
    case DISPUTED = 'disputed';
    case WRITTEN_OFF = 'written_off';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ISSUED => 'Issued / Sent',
            self::PENDING => 'Pending',
            self::PAID => 'Paid',
            self::PAID_PARTIALLY => 'Paid Partially',
            self::OVERDUE => 'Overdue',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
            self::FAILED => 'Payment Attempt Failed',
            self::DISPUTED => 'Invoice Disputed by Client',
            self::WRITTEN_OFF => 'Written Off',
            self::ARCHIVED => 'Archived Invoice',
        };
    }

    public static function values(): array
    {
        return array_map(fn (RepairStatus $status) => $status->value, self::cases());
    }
}