<?php

namespace App\Contracts;

use App\Emulators\EmulatorDatabase;
use App\Emulators\EmulatorStatistics;
use App\Mail;

interface Emulator
{
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
     * Get a mail model configured with the current emulator
     *
     * @return Mail
     */
    public function mail();

    /**
     * Get the emulator statistics
     *
     * @return EmulatorStatistics
     */
    public function statistics();
}
