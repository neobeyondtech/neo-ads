<?php

namespace App\Enums;

enum PartnerStatus: string
{
    case DRAFT = 'draft';
    case PENDING_VERIFICATION = 'pending verification';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
    case REJECTED = 'rejected';

 
    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::PENDING_VERIFICATION => 'Pending Verification',
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::SUSPENDED => 'Suspended',
            self::REJECTED => 'Rejected',
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
