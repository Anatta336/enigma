<?php

namespace Tests\Unit;

use App\Models\Rotor;
use App\Service\Rotation;
use App\Service\Stepper;
use PHPUnit\Framework\TestCase;

class RotationTest extends TestCase
{
    /** @test */
    public function valid_value_remains(): void
    {
        $this->assertEquals(4, Rotation::constrainByLooping(4));
    }

    /** @test */
    public function large_value_loops(): void
    {
        $this->assertEquals(2, Rotation::constrainByLooping(28));
    }

    /** @test */
    public function negative_value_loops(): void
    {
        $this->assertEquals(25, Rotation::constrainByLooping(-1));
    }

    /** @test */
    public function large_negative_value_loops(): void
    {
        $this->assertEquals(24, Rotation::constrainByLooping(-80));
    }

    /** @test */
    public function simple_advance(): void
    {
        $this->assertEquals(6, Rotation::advanceWithLoop(5));
    }

    /** @test */
    public function advancing_loops_on_26(): void
    {
        $this->assertEquals(0, Rotation::advanceWithLoop(25));
    }

    /** @test */
    public function advancing_outside_range_loops_on_26(): void
    {
        $this->assertEquals(10, Rotation::advanceWithLoop(35));
    }
}
