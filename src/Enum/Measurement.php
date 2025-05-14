<?php

declare(strict_types=1);

namespace App\Enum;

enum Measurement: int
{
    case KILOGRAMM = 1;
    case GRAMM = 2;
    case LITERS = 3;
    case ITEMS = 4;
    case MILLILITERS = 5;

    public function toCode(): string
    {
        return match($this) {
            self::KILOGRAMM => 'kilogramm',
            self::GRAMM => 'gramm',
            self::LITERS => 'liters',
            self::ITEMS => 'items',
            self::MILLILITERS => 'milliliters'
        };
    }

    public static function fromCode(string $code): self
    {
        return match($code) {
            'gramm' => self::GRAMM,
            'liters' => self::LITERS,
            'items' => self::ITEMS,
            'milliliters' => self::MILLILITERS,
            default => self::KILOGRAMM,
        };
    }
}
