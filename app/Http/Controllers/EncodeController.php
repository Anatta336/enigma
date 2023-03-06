<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Reflector;
use App\Models\Rotor;
use Illuminate\Routing\Controller as BaseController;

class EncodeController extends BaseController
{
    public function __invoke()
    {
        $machine = new Machine(
            Reflector::fromConfig('UKW-B'),
            Rotor::fromConfig(request('rotors.leftRotor.name'))
                ->setIndexRingPosition(request('rotors.leftIndex')),
            Rotor::fromConfig(request('rotors.middleRotor.name'))
                ->setIndexRingPosition(request('rotors.middleIndex')),
            Rotor::fromConfig(request('rotors.rightRotor.name'))
                ->setIndexRingPosition(request('rotors.rightIndex')),
        );

        $output = '';

        foreach (mb_str_split(request('input') ?? '') as $letter) {
            $output .= $machine->encryptLetter($letter);
        }

        return $output;
    }
}
