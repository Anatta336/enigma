<?php

namespace App\Service;

use App\Models\Machine;
use App\Models\Reflector;
use App\Models\Rotor;

class Rainbow
{
    public static function encodeSettings(array $rotorNames, array $indices): string
    {
        return $rotorNames[0].'.'
            .$indices[0].'.'
            .$rotorNames[1].'.'
            .$indices[1].'.'
            .$rotorNames[2].'.'
            .$indices[2];
    }

    public static function decodeSettings(string $encodedSettings): array
    {
        $split = explode('.', $encodedSettings);

        return [
            'leftRotorName'   => $split[0],
            'leftIndex'       => $split[1],
            'middleRotorName' => $split[2],
            'middleIndex'     => $split[3],
            'rightRotorName'  => $split[4],
            'rightIndex'      => $split[5],
        ];
    }

    public static function createMachineFromEncodedSettings(string $encodedSettings): Machine
    {
        $split = explode('.', $encodedSettings);

        return new Machine(
            Reflector::fromConfig('UKW-B'),
            Rotor::fromConfig($split[0])
                ->setIndexRingPosition($split[1]),
            Rotor::fromConfig($split[2])
                ->setIndexRingPosition($split[3]),
            Rotor::fromConfig($split[4])
                ->setIndexRingPosition($split[5]),
        );
    }

    public static function encodeKey(string $plainText, string $encrypted): string
    {
        return $plainText.'.'.$encrypted;
    }
}
