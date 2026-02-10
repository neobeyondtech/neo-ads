<?php

namespace App\Enums;

enum StickerAreaType: string
{
    /*case FULL_WRAP     = 'full_wrap';
    case PARTIAL_WRAP  = 'partial_wrap';

    case DOOR_LEFT     = 'door_left';
    case DOOR_RIGHT    = 'door_right';
    case DOOR_BOTH     = 'door_both';

    case HOOD          = 'hood';*/
    case REAR_WINDOW   = 'rear_window';
    /*case REAR_BUMPER   = 'rear_bumper';

    case ROOF          = 'roof';
    case SIDE_PANEL    = 'side_panel';
    case MAGNET        = 'magnet';*/

    /**
     * Price per sticker area type (in thousands of Rupiah)
     */
    public function price(): int
    {
        return match ($this) {
            self::REAR_WINDOW   => 845,   // 180k per vehicle
        };
    }

    /**
     * Price per sticker area type (in thousands of Rupiah)
     */
    public function cost(): int
    {
        return match ($this) {
            self::REAR_WINDOW   => 150000,   // 180k per vehicle
        };
    }    

     /**
     * Get all values for validation / dropdown
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all labels for dropdown
     */
    public function label(): string
    {
        return match ($this) {
            self::REAR_WINDOW   => 'Rear Window',
        };
    }

    /**
     * Dropdown-ready list with prices
     */
    public static function options(): array
    {
        return array_map(
            fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
                'price' => $case->price(),
                'cost' => $case->cost(),
            ],
            self::cases()
        );
    }
}