<?php

namespace App\Enums;

enum VehicleType: string
{
    case CAR     = 'car';
    case MOTORCYCLE  = 'motorcycle';
    case BUS     = 'bus';
    case MINIBUS    = 'minibus';

    /**
     * Human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::CAR     => 'Mobil',
            self::MOTORCYCLE  => 'Motor',
            self::BUS     => 'Bus',
            self::MINIBUS    => 'Minibus',
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