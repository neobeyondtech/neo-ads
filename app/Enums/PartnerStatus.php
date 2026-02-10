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

    /**
     * Return an array for dropdown lists
     */
    public static function options(): array
    {
        return [
            self::DRAFT->value => 'Draft',
            self::PENDING_VERIFICATION->value => 'Pending Verification',
            self::ACTIVE->value => 'Active',
            self::INACTIVE->value => 'Inactive',
            self::SUSPENDED->value => 'Suspended',
            self::REJECTED->value => 'Rejected',
        ];
    }
}
