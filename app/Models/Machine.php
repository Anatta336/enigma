<?php

namespace App\Models;

use App\Service\Alphabet;

/**
 * Represents the current state of an Enigma I machine.
 *
 * Example usage:
 * $machine = new Machine(
 *      Reflector::fromConfig('UKW-B'),
 *      Rotor::fromConfig('III'),
 *      Rotor::fromConfig('II'),
 *      Rotor::fromConfig('I')
 * );
 * $machine->encryptLetter('A');
 * // Returns 'N'
 *
 */
class Machine
{
    public readonly Reflector $reflector;
    public readonly Rotor $leftRotor;
    public readonly Rotor $middleRotor;
    public readonly Rotor $rightRotor;

    public function __construct(Reflector $reflector,
        Rotor $leftRotor, Rotor $middleRotor, Rotor $rightRotor)
    {
        $this->reflector = $reflector;
        $this->leftRotor = $leftRotor;
        $this->middleRotor = $middleRotor;
        $this->rightRotor = $rightRotor;
    }

    public function encryptLetter(string $input): string
    {
        $value = Alphabet::letterToValue($input);

        // @TODO advance rotor rotation(s)

        // @TODO plugboard as first step.

        // Could so something with an array of steps or a pipeline, but simple is fine.
        // Pass the value through each rotor in turn, through the reflector, then back out.
        $value = $this->rightRotor->encodeFromRight($value);
        $value = $this->middleRotor->encodeFromRight($value);
        $value = $this->leftRotor->encodeFromRight($value);
        $value = $this->reflector->encodeFromRight($value);
        $value = $this->leftRotor->encodeFromLeft($value);
        $value = $this->middleRotor->encodeFromLeft($value);
        $value = $this->rightRotor->encodeFromLeft($value);

        // @TODO plugboard again

        return Alphabet::valueToLetter($value);
    }
}
