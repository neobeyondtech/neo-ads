<?php

namespace App\Enums;

enum ReportStatus: string
{
    case PENDING = 'pending';
    case VERIFIED = 'verified';
    case REJECTED = 'rejected';
    case IN_REVIEW = 'reviewed';

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
            self::PENDING   => 'Pending',
            self::VERIFIED  => 'Verified',
            self::REJECTED  => 'Rejected',
            self::IN_REVIEW => 'In Review',
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
