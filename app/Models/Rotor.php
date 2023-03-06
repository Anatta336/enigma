<?php

namespace App\Models;

use App\Service\Alphabet;
use App\Service\Rotation;
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

        assert(isset($config['notch']),
            "Attempt to create Rotor that has no notch position in config. \$rotorName: {$rotorName}"
        );
        $notchPosition = Alphabet::letterToValue($config['notch']);

        return static::fromAlphaMapping($alphaMapping, $notchPosition);
    }

    protected static function fromAlphaMapping(array $alphaMapping, int $notchPosition = 0): ?static
    {
        // Convert the alphabetical mapping into integer values.
        // The (...) syntax is using PHP 8.1's first-class callables.
        $mapping = Arr::map($alphaMapping, Alphabet::letterToValue(...));

        return new static($mapping, $notchPosition);
    }

    // PHP 8.1's readonly means these can be initialised but then never changed.
    public readonly array $mappingRightToLeft;
    public readonly array $mappingLeftToRight;

    public readonly int $notchPosition;

    /**
     * Represents the offset of the wiring within the wheel. Unlike rotation, it doesn't move the notch.
     *
     * This value will remain constant while encoding an individual message.
     */
    protected int $indexRingPosition = 0;

    /**
     * Represents the rotation of the whole wheel, wiring and notch.
     *
     * This value may change during the process of encoding a message.
     */
    protected int $rotation = 0;

    public function __construct(array $mapping, int $notchPosition = 0)
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

        $this->notchPosition = $notchPosition;
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
        $this->indexRingPosition = Rotation::constrainByLooping($index);

        return $this;
    }

    public function getRotation(): int
    {
        return $this->rotation;
    }

    public function setRotation(int $index): static
    {
        $this->rotation = Rotation::constrainByLooping($index);

        return $this;
    }

    /**
     * @return int Position of the notch relative to the "bottom" of the rotor.
     *             When the notch is at relative position 0 it's at the bottom.
     */
    public function getNotchRelativePosition(): int
    {
        return Rotation::constrainByLooping($this->notchPosition - $this->rotation);
    }

    protected function applyOffset(int $value): int
    {
        return Rotation::constrainByLooping($value + $this->rotation - $this->indexRingPosition);
    }

    protected function revertOffset(int $value): int
    {
        return Rotation::constrainByLooping($value - ($this->rotation - $this->indexRingPosition));
    }
}
