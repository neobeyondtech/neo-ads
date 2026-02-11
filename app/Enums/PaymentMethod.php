<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case BANK_TRANSFER = 'bank_transfer';
    case CREDIT_CARD = 'credit_card';
    case E_WALLET = 'e_wallet';
    case CASH = 'cash';

    /**
     * Get all values for validation / dropdown
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get label for UI
     */
    public function label(): string
    {
        return match ($this) {
            self::BANK_TRANSFER => 'Bank Transfer',
            self::CREDIT_CARD => 'Credit Card',
            self::E_WALLET => 'E-Wallet',
            self::CASH => 'Cash',
        };
    }

    /**
     * Dropdown-ready list
     */
    public static function options(): array
    {
        return array_map(
            fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }
}
