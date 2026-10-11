<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\HasEnumOptions;

enum PaymentMethod: string
{
    use HasEnumOptions;

    case CASH = 'cash';
    case CARD = 'card';
    case BANK_TRANSFER = 'bank_transfer';
    case ONLINE = 'online';
    case CHEQUE = 'cheque';
    case PAYPAL = 'paypal';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::CARD => 'Credit / Debit Card',
            self::BANK_TRANSFER => 'Bank Transfer',
            self::ONLINE => 'Online Payment',
            self::CHEQUE => 'Cheque',
            self::PAYPAL => 'PayPal',
            self::OTHER => 'Other',
        };
    }
}
