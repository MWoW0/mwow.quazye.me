<?php

namespace Tests\Unit;

use App\Facades\Emulator;
use Tests\TestCase;

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
        $this->assertEquals(['SkyFire', 'Mangos'], Emulator::supported());
    }

    /** @test */
    public function itChecksWhetherGivenEmulatorIsSupported()
    {
        $this->assertTrue(Emulator::isSupported('SkyFire'));
        $this->assertFalse(Emulator::isSupported('InvalidDriverName'));
    }
}
