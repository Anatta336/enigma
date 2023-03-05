<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**
 * Models a reflector in the Enigma machine.
 *
 * Borrows internal logic from the rotors. Effectively the reflector is a stationary
 * rotor that has a symmetric wiring pattern.
 */
class Reflector extends Rotor
{
    public static function fromConfig(string $reflectorName): ?static
    {
        $config = Arr::first(config('enigma.reflectors'), function ($value) use ($reflectorName) {
            return $value['name'] === $reflectorName;
        });

        $alphaMapping = $config['mapping'];
        if (!$alphaMapping) {
            Log::error("Attempt to create Reflector that has no config. \$reflectorName: {$reflectorName}");
            return null;
        }

        $reflector = static::fromAlphaMapping($alphaMapping);

        if (!$reflector) {
            return null;
        }

        assert($reflector->checkIfSymmetric(),
            'Reflector mapping should be symmetric, appears not for '.$reflectorName
        );

        return $reflector;
    }
}
