<?php

namespace App\Enums;

enum VehicleColor: string
{
    case WHITE     = 'white';
    case BLACK     = 'black';
    case SILVER      = 'silver';
    case RED       = 'red';
    case BLUE      = 'blue';
    case GREEN     = 'green';
    case YELLOW    = 'yellow';
    case BROWN     = 'brown';

    /**
     * Human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::WHITE     => 'Putih',
            self::BLACK     => 'Hitam',
            self::RED       => 'Merah',
            self::BLUE      => 'Biru',
            self::GREEN     => 'Hijau',
            self::SILVER    => 'Abu-abu/Silver',
            self::YELLOW    => 'Kuning',
            self::BROWN     => 'Coklat',
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