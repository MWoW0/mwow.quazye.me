<?php

namespace App\Contracts;

use App\Emulators\EmulatorDatabase;
use App\Emulators\EmulatorStatistics;
use App\Mail;

interface Emulator
{
    /**
     * The WoW expansion name
     *
     * @return string|null
     */
    public function expansion(): ?string;

    /**
     * Get a value from the emulators configurations
     *
     * @param  string|null $key
     * @return mixed
     */
    public function config($key = null);

    /**
     * Get the emulator database connections capsule
     *
     * @return EmulatorDatabase
     */
    public function database();

    /**
     * Get the emulator statistics
     *
     * @return EmulatorStatistics
     */
    public function statistics();
}
