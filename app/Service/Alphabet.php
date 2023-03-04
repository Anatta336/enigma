<?php
namespace App\Service;

use Illuminate\Support\Str;

class Alphabet
{
    private const VALUE_A = 97;

    /**
     * @param string $letter Letter to turn into an integer value.
     *
     * @return int Integer value representing the letter. 0 for 'a', 1 for 'b', and so on.
     */
    public static function letterToValue(string $letter): int
    {
        $byteValue = ord(Str::ascii(Str::lower($letter)));

        return $byteValue - self::VALUE_A;
    }

    /**
     * @param int $value Value to turn into a letter.
     *
     * @return string Capital letter as represented by the value provided.
     */
    public static function valueToLetter(int $value): string
    {
        ValidValue::assertValidValue($value);

        return Str::upper(chr($value + self::VALUE_A));
    }
}
