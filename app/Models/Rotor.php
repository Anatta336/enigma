<?php
namespace App\Models;

use App\Service\Alphabet;
use App\Service\ValidValue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;


/**
 * Note this isn't a Laravel model. Should it still be in the Models namespace? Maybe.
 */
class Rotor
{
    public static function fromConfig(string $configName): ?Rotor
    {
        $alphaMapping = config('rotors.'.$configName.'.mapping');
        if (!$alphaMapping) {
            Log::error("Attempt to create Rotor that has no config. \$configName: {$configName}");
            return null;
        }

        // Convert the alphabetical mapping into integer values.
        // The (...) syntax is using PHP 8.1's first-class callables.
        $mapping = Arr::map($alphaMapping, Alphabet::letterToValue(...));

        return new Rotor($mapping);
    }

    // PHP 8.1's readonly means these can be initialised but then never changed.
    public readonly array $mappingRightToLeft;
    public readonly array $mappingLeftToRight;

    public function __construct(array $mapping)
    {
        assert(count(array_keys($mapping)) == 26,
            'Rotor must have a mapping with 26 values.'
        );

        // Check the mapping is valid.
        foreach ($mapping as $key => $value) {
            ValidValue::assertValidValue($key);
            ValidValue::assertValidValue($value);
        }

        $this->mappingRightToLeft = $mapping;
        $this->mappingLeftToRight = array_flip($mapping);
    }

    /**
     * Pass a signal through the wheel, from the right.
     *
     * @param int $input Value of input coming into the right.
     * @return int Value coming out of the left.
     * @throws Exception if input is not valid.
     */
    public function encodeFromRight(int $input): int
    {
        ValidValue::assertValidValue($input);

        return $this->mappingRightToLeft[$input];
    }

    /**
     * Pass a signal through the rotor, from the left.
     *
     * @param int $input Value of input coming into the left.
     * @return int Value coming out of the right.
     */
    public function encodeFromLeft(int $input): int
    {
        ValidValue::assertValidValue($input);

        return $this->mappingLeftToRight[$input];
    }
}
