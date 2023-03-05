<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;

class Reflector extends Rotor
{
    public static function fromConfig(string $configName): ?Reflector
    {
        $alphaMapping = config('reflectors.'.$configName.'.mapping');
        if (!$alphaMapping) {
            Log::error("Attempt to create Reflector that has no config. \$configName: {$configName}");
            return null;
        }

        $reflector = self::fromAlphaMapping($alphaMapping);

        assert($reflector->checkIfSymmetric(),
            'Reflector mapping should be symmetric, appears not for '.$configName
        );

        return $reflector;
    }
}
