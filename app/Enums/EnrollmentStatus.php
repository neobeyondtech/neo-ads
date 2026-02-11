<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELED = 'canceled';
    /**
     * Human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELED => 'Canceled',
        };
    }

    /**
     * Dropdown list
     * [
     *   ['value' => 'draft', 'label' => 'Draft'],
     *   ...
     * ]
     */
    public static function dropdown(): array
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
