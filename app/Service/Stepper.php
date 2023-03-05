<?php

namespace App\Service;

use App\Models\Rotor;

class Stepper
{
    /**
     * Advance the state of the given rotors. This function mutates the provided objects.
     */
    public static function advance(Rotor $left, Rotor $middle, Rotor $right): void
    {
        $rightRotation = $rightInitial = $right->getRotation();
        $middleRotation = $middleInitial = $middle->getRotation();
        $leftRotation = $leftInitial = $left->getRotation();

        $rightNotchPosition = $right->getNotchRelativePosition();
        $middleNotchPosition = $middle->getNotchRelativePosition();

        // Right always moves forwards.
        $rightRotation = Rotation::advanceWithLoop($rightInitial);

        // In this unique situation, there's a "double step" meaning middle advances without
        // the right rotor's notch being in position 0.
        $isDoubleStep = ($rightNotchPosition === Rotation::LOOP_SIZE - 1
            && $middleNotchPosition === 0);

        if (($rightNotchPosition === 0) || $isDoubleStep) {
            // Right triggers middle to advance.
            $middleRotation = Rotation::advanceWithLoop($middleInitial);

            if ($middleNotchPosition === 0) {
                // Middle triggers left to advance.
                $leftRotation = Rotation::advanceWithLoop($leftInitial);
            }
        }

        // Store the rotations.
        // @OPTO: Only store if value changed?
        // @OPTO: Whole thing could be inlined, if that actually helps in 8.2?
        $right->setRotation($rightRotation);
        $middle->setRotation($middleRotation);
        $left->setRotation($leftRotation);
    }
}
