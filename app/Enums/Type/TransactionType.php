<?php

declare(strict_types=1);

namespace App\Enums\Type;

use App\Traits\HasEnumOptions;

enum TransactionType: string
{
    use HasEnumOptions;

    case PAYMENT = 'payment';
    case REFUND = 'refund';
    case DISCOUNT = 'discount';

    public function label(): string
    {
        return match ($this) {
            self::PAYMENT => 'Payment',
            self::REFUND => 'Refund',
            self::DISCOUNT => 'Discount',
        };
    }
}
