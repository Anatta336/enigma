<?php

namespace App\Service;

class ValidValue
{
    public static function assertValidValue(int $value): void
    {
        assert(is_integer($value),
            "Value {$value} is not an integer."
        );
        assert($value >= 0 && $value <= 25,
            "Value {$value} is outside 0 to 25 range."
        );
    }
}
