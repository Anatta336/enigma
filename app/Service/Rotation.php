<?php

namespace App\Service;

class Rotation
{
    const LOOP_SIZE = 26;

    public static function advanceWithLoop(int $value): int
    {
        return self::constrainByLooping($value + 1);
    }

    public static function constrainByLooping(int $value): int
    {
        // Using modulo to "wrap around" so 26 becomes 0, 27 becomes 1, etc.
        $value %= self::LOOP_SIZE;

        // Modulo can give a negative value, which needs correcting.
        $value += $value < 0 ? self::LOOP_SIZE : 0;

        return $value;
    }
}
