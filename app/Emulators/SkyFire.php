<?php

namespace App\Emulators;

use App\Contracts\Emulator;
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
     * The WoW expansion name
     *
     * @var string
     */
    protected $expansion;

    /**
     * The WoW expansion name
     *
     * @return string|null
     */
    public function expansion(): ?string
    {
        return $this->expansion;
    }

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
     * Get the emulator statistics
     *
     * @return EmulatorStatistics
     */
    public function statistics()
    {
        return new EmulatorStatistics($this);
    }
}
