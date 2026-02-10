<?php

namespace App\Enums;

enum OwnerType: string
{
    case OWN     = 'own';
    case SPOUSE     = 'spouse';
    case CHILD      = 'child';
    case PARENT       = 'parent';
    case FRIEND      = 'friend';

    /**
     * Human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::OWN     => 'Milik Sendiri',
            self::SPOUSE     => 'Pasangan',
            self::CHILD      => 'Anak',
            self::PARENT       => 'Orang Tua',
            self::FRIEND      => 'Teman',
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