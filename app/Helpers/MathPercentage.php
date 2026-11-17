<?php

declare(strict_types=1);

namespace App\Helpers;


final class MathPercentage
{
    # Calculate 20% of 150
    public static function of(float $value, float $percentage): float
    {
        return $value * ($percentage / 100); // value: 10
    }

    # Calculate what percentage 30% is of 150
    public static function calculate(float $value, float $total): float
    {
        return $total == 0 ? 0 : ($value / $total) * 100; // percentage: 10%
    }

    # Increase a value by 20%
    public static function increase(float $value, float $percentage): float
    {
        return $value * (1 + $percentage / 100); // value: 20
    }

    # Decrease a value by 20%
    public static function decrease(float $value, float $percentage): float
    {
        return $value * (1 - $percentage / 100); // value: 5
    }
}
