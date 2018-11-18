<?php

namespace Tests\Unit;

use App\Facades\Emulator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupportedEmulatorsTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $manager = new Class {
            function getSkyFireDriver() {}
        };

        Emulator::swap($manager);
    }

    /** @test */
    public function itListsTheSupportedEmulators()
    {
        $this->assertEquals(['SkyFire'], Emulator::supported());
    }

    /** @test */
    public function itChecksWhetherGivenEmulatorIsSupported()
    {
        $this->assertTrue(Emulator::supported('SkyFire'));
        $this->assertFalse(Emulator::supported('InvalidDriverName'));
    }
}
