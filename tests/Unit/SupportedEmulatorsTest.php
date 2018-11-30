<?php

namespace Tests\Unit;

use App\Facades\Emulator;
use Tests\TestCase;
use function config;

class SupportedEmulatorsTest extends TestCase
{
    /** @test */
    public function itListsTheSupportedEmulators()
    {
        config([
            'services.skyfire.supported' => true,
            'services.mangos.supported' => true
        ]);

        $this->assertEquals(['SkyFire', 'Mangos'], Emulator::supported());

        config(['services.skyfire.supported' => false]);

        $this->assertEquals(['Mangos'], Emulator::supported());
    }

    /** @test */
    public function itChecksWhetherGivenEmulatorIsSupported()
    {
        config(['services.skyfire.supported' => true]);
        $this->assertTrue(Emulator::isSupported('SkyFire'));
        $this->assertFalse(Emulator::isSupported('InvalidDriverName'));

        config(['services.mangos.supported' => false]);
        $this->assertFalse(Emulator::isSupported('Mangos'));

        config(['services.mangos.cataclysm.supported' => false]);
        $this->assertFalse(Emulator::isSupported('Mangos', 'cataclysm'));

        config(['services.mangos.supported' => true]);
        $this->assertTrue(Emulator::isSupported('Mangos'));
    }
}
