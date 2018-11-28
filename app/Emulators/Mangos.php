<?php

namespace App\Emulators;


use App\Contracts\Emulator;

class Mangos implements Emulator
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
     * Mangos constructor.
     *
     * @param string $expansion
     */
    public function __construct(string $expansion)
    {
        $this->expansion = $expansion;
    }

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
        return array_get(config("services.mangos.{$this->expansion}"), $key);
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
     * @return EmulatorStatistics
     */
    public function statistics()
    {
        return new EmulatorStatistics($this);
    }
}