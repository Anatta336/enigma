<?php

namespace App\Models;

use App\Service\Alphabet;
use App\Service\ValidValue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**
 * Represents one of the rotors in the Enigma.
 *
 * A signal enters the rotor with one value and is mapped according to the wiring and
 * rotation of that rotor.
 *
 * Input and output are handled as integer values. As a circle it's somewhat arbitrary where
 * 'zero' is. We're using where A would be when the index ring is in position 0.
 *
 * @TODO: Movement of rotors, but during encoding and through wheel settings.
 */
class Rotor
{
    public static function fromConfig(string $rotorName): ?static
    {
        $config = Arr::first(config('enigma.rotors'), function ($value) use ($rotorName) {
            return $value['name'] === $rotorName;
        });

        $alphaMapping = $config['mapping'];
        if (!$alphaMapping) {
            Log::error("Attempt to create Rotor that has no config. \$rotorName: {$rotorName}");
            return null;
        }

        return static::fromAlphaMapping($alphaMapping);
    }

    protected static function fromAlphaMapping(array $alphaMapping): ?static
    {
        // Convert the alphabetical mapping into integer values.
        // The (...) syntax is using PHP 8.1's first-class callables.
        $mapping = Arr::map($alphaMapping, Alphabet::letterToValue(...));

        return new static($mapping);
    }

    // PHP 8.1's readonly means these can be initialised but then never changed.
    public readonly array $mappingRightToLeft;
    public readonly array $mappingLeftToRight;

    protected int $indexRingPosition = 0;
    protected int $rotation = 0;

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

        return $this->revertOffset(
            $this->mappingRightToLeft[
                $this->applyOffset($input)
            ]
        );
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

        return $this->revertOffset(
            $this->mappingLeftToRight[
                $this->applyOffset($input)
            ]
        );
    }

    public function checkIfSymmetric(): bool
    {
        return $this->mappingLeftToRight === $this->mappingRightToLeft;
    }

    public function setIndexRingPosition(int $index): static
    {
        assert($index >= 0 && $index <= 25,
            "Rotor index ring position must be between 0 and 25. {$index} given."
        );

        $this->indexRingPosition = $index;

        return $this;
    }

    public function setRotation(int $index): static
    {
        assert($index >= 0 && $index <= 25,
            "Rotor rotation must be between 0 and 25. {$index} given."
        );

        $this->rotation = $index;

        return $this;
    }

    protected function applyOffset(int $value): int
    {
        $value += $this->indexRingPosition + $this->rotation;

        // Using modulo to "wrap around" so 26 becomes 0, 27 becomes 1, etc.
        $value %= 26;

        // Modulo can give a negative value, which needs correcting.
        $value += $value < 0 ? 26 : 0;

        return $value;
    }

    protected function revertOffset(int $value): int
    {
        $value -= $this->indexRingPosition + $this->rotation;

        // Using modulo to "wrap around" so 26 becomes 0, 27 becomes 1, etc.
        $value %= 26;

        // Modulo can give a negative value, which needs correcting.
        $value += $value < 0 ? 26 : 0;

        return $value;
    }
}
