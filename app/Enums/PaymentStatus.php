<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

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
            self::PENDING  => 'Pending',
            self::PAID     => 'Paid',
            self::FAILED   => 'Failed',
            self::REFUNDED => 'Refunded',
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
