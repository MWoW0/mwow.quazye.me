<?php

namespace App\Emulators;

use App\Contracts\Emulator;
use App\Mail;
use function array_get;
use function config;

class SkyFire implements Emulator
{
    /**
     * Get the database capsule instance
     *
     * @var EmulatorDatabase
     */
    protected $database;

    /**
     * Get a value from the emulators configurations
     *
     * @param  string|null $key
     * @return mixed
     */
    public function config($key = null)
    {
        return array_get(config('services.skyfire'), $key);
    }

    /**
     * Get the emulator database connections capsule
     *
     * @return EmulatorDatabase
     */
    public function database()
    {
        if ($this->database) {
            return $this->database;
        }

        return $this->database = new EmulatorDatabase($this);
    }

    /**
     * Get a mail model configured with the current emulator
     *
     * @return Mail
     */
    public function mail()
    {
        return Mail::makeWithEmulator($this);
    }

    /**
     * Get the emulator statistics
     *
     * @return EmulatorStatistics
     */
    public function statistics()
    {
        return new EmulatorStatistics($this);
    }
}
