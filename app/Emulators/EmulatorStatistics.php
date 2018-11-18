<?php

namespace App\Emulators;


use App\Account;
use App\Contracts\Emulator;
use App\Contracts\Emulators\GathersGameStatistics;

class EmulatorStatistics implements GathersGameStatistics
{
    /**
     * The Emulator instance
     *
     * @var Emulator
     */
    protected $emulator;

    /**
     * EmulatorStatistics constructor.
     *
     * @param Emulator $emulator
     */
    public function __construct(Emulator $emulator)
    {
        $this->emulator = $emulator;
    }

    /**
     * Get the underlying emulator instance
     *
     * @return Emulator
     */
    public function emulator()
    {
        return $this->emulator;
    }

    /**
     * Determine latency to the server by measuring the time spent on establishing a socket connection to the server
     *
     * @return null | integer
     */
    public function latency()
    {
        $start = microtime(true);
        $connected = @fsockopen($this->emulator->config('host'), $this->emulator->config('port'));

        if (!$connected) {
            return null;
        }

        return round((microtime(true) - $start) * 1000);
    }

    /**
     * Get the amount of online players
     *
     * @return integer
     */
    public function playersOnline()
    {
        return Account::online()->count();
    }

    /**
     * Get the amount of active players
     *
     * @return int
     */
    public function playersActive()
    {
        return Account::active()->count();
    }

    /**
     * Get the amount of inactive players
     *
     * @return int
     */
    public function playersInactive()
    {
        return Account::inactive()->count();
    }

    /**
     * Get the amount of players created within last month
     *
     * @return int
     */
    public function playersRecentlyCreated()
    {
        return Account::recentlyCreated()->count();
    }

    /**
     * Get the total amount of game accounts
     *
     * @return int
     */
    public function playersTotal()
    {
        return Account::query()->count();
    }
}
