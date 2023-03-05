<?php

namespace Tests\Unit;

use App\Models\Rotor;
use App\Service\Stepper;
use PHPUnit\Framework\TestCase;

class StepperTest extends TestCase
{
    protected Rotor $left;
    protected Rotor $middle;
    protected Rotor $right;

    protected function prepareRotors(): void
    {
        // Mapping that doesn't change any values.
        $identityMapping = range(0, 25);

        $this->left   = new Rotor($identityMapping, 10);
        $this->middle = new Rotor($identityMapping, 10);
        $this->right  = new Rotor($identityMapping, 10);
    }

    /**
     * Finds what rotation value will be needed for the rotor to be positioned so it triggers
     * its neighbour to advance.
     */
    protected function getRotationForNotchAtBottom(Rotor $rotor): int
    {
        return $rotor->notchPosition;
    }

    /** @test */
    public function right_rotor_advances_one_without_others(): void
    {
        // Prepare
        $this->prepareRotors();
        $this->right->setRotation(3);
        $this->middle->setRotation(2);
        $this->left->setRotation(1);

        // Confirm
        $this->assertEquals(3, $this->right->getRotation());
        $this->assertEquals(2, $this->middle->getRotation());
        $this->assertEquals(1, $this->left->getRotation());

        // Check that the right-most is not positioned to trigger a middle advance.
        $this->assertNotEquals(
            $this->getRotationForNotchAtBottom($this->right),
            $this->right->getRotation()
        );

        // Act
        Stepper::advance($this->left, $this->middle, $this->right);

        // Test
        $this->assertEquals(4, $this->right->getRotation());
        $this->assertEquals(2, $this->middle->getRotation());
        $this->assertEquals(1, $this->left->getRotation());
    }

    /** @test */
    public function right_rotor_loops(): void
    {
        $this->prepareRotors();
        $this->right->setRotation(25);

        $this->assertEquals(25, $this->right->getRotation());

        Stepper::advance($this->left, $this->middle, $this->right);

        $this->assertEquals(0, $this->right->getRotation());
    }

    /** @test */
    public function middle_rotor_advances_when_right_notch_passes(): void
    {
        $this->prepareRotors();

        // This places the notch "at the bottom", ready to advance the next rotor.
        $this->right->setRotation(10);
        $this->middle->setRotation(2);
        $this->left->setRotation(1);

        $this->assertEquals(10, $this->right->getRotation());
        $this->assertEquals(2, $this->middle->getRotation());
        $this->assertEquals(1, $this->left->getRotation());

        Stepper::advance($this->left, $this->middle, $this->right);

        // Right has advanced.
        $this->assertEquals(11, $this->right->getRotation());

        // Middle has advanced.
        $this->assertEquals(3, $this->middle->getRotation());

        // Left has remained.
        $this->assertEquals(1, $this->left->getRotation());
    }

    /** @test */
    public function left_rotor_advances_when_middle_notch_passes(): void
    {
        $this->prepareRotors();

        // This places the notch "at the bottom", ready to advance the next rotor.
        $this->right->setRotation(10);

        // Middle notch also at the bottom, ready to advance.
        $this->middle->setRotation(10);

        $this->left->setRotation(1);

        $this->assertEquals(10, $this->right->getRotation());
        $this->assertEquals(10, $this->middle->getRotation());
        $this->assertEquals(1, $this->left->getRotation());

        Stepper::advance($this->left, $this->middle, $this->right);

        // Right has advanced.
        $this->assertEquals(11, $this->right->getRotation());

        // Middle has advanced.
        $this->assertEquals(11, $this->middle->getRotation());

        // Left has advanced.
        $this->assertEquals(2, $this->left->getRotation());
    }

    /** @test */
    public function middle_rotor_normally_doesnt_advance_with_right_at_top(): void
    {
        $this->prepareRotors();

        // This places the notch "at the top", which normally doesn't advance the next rotor.
        $this->right->setRotation(11);
        $this->middle->setRotation(2);
        $this->left->setRotation(1);

        $this->assertEquals(11, $this->right->getRotation());
        $this->assertEquals(2, $this->middle->getRotation());
        $this->assertEquals(1, $this->left->getRotation());

        Stepper::advance($this->left, $this->middle, $this->right);

        // Right has advanced.
        $this->assertEquals(12, $this->right->getRotation());

        // Middle has remained.
        $this->assertEquals(2, $this->middle->getRotation());

        // Left has remained.
        $this->assertEquals(1, $this->left->getRotation());
    }

    /** @test */
    public function middle_rotor_normally_doesnt_advance_early(): void
    {
        $this->prepareRotors();

        $this->right->setRotation(3);

        // This places the notch "at the bottom", ready to advance the next rotor.
        // With the right rotor in the correct place, this could cause a double step event.
        $this->middle->setRotation(10);

        $this->left->setRotation(1);

        $this->assertEquals(3, $this->right->getRotation());
        $this->assertEquals(10, $this->middle->getRotation());
        $this->assertEquals(1, $this->left->getRotation());

        Stepper::advance($this->left, $this->middle, $this->right);

        // Right has advanced.
        $this->assertEquals(4, $this->right->getRotation());

        // Middle has remained.
        $this->assertEquals(10, $this->middle->getRotation());

        // Left has remained.
        $this->assertEquals(1, $this->left->getRotation());
    }

    /** @test */
    public function middle_rotor_advances_for_double_step(): void
    {
        $this->prepareRotors();

        // This places the notch "at the top", which normally doesn't advance the next rotor.
        $this->right->setRotation(11);

        // This places the notch "at the bottom", ready to advance the next rotor.
        // With the right rotor at the top, this should cause a double step event.
        $this->middle->setRotation(10);

        $this->left->setRotation(1);

        $this->assertEquals(11, $this->right->getRotation());
        $this->assertEquals(10, $this->middle->getRotation());
        $this->assertEquals(1, $this->left->getRotation());

        Stepper::advance($this->left, $this->middle, $this->right);

        // Right has advanced.
        $this->assertEquals(12, $this->right->getRotation());

        // Middle has advanced.
        $this->assertEquals(11, $this->middle->getRotation());

        // Left has advanced.
        $this->assertEquals(2, $this->left->getRotation());
    }
}
