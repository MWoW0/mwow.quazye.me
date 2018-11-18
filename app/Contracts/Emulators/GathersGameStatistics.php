<?php

namespace App\Contracts\Emulators;

use App\Contracts\EmulatorContract;

interface GathersGameStatistics
{
    /**
     * Get the underlying emulator instance
     *
     * @return EmulatorContract
     */
    public function emulator();

    /**
     * Determine latency to the server by measuring the time spent on establishing a socket connection to the server
     *
     * @return null | integer
     */
    public function latency();

    /**
     * Get the amount of online players
     *
     * @return integer
     */
    public function playersOnline();

    /**
     * Get the amount of active players
     *
     * @return int
     */
    public function playersActive();

    /**
     * Get the amount of inactive players
     *
     * @return int
     */
    public function playersInactive();

    /**
     * Get the amount of players created within last month
     *
     * @return int
     */
    public function playersRecentlyCreated();

    /**
     * Get the total amount of game accounts
     *
     * @return int
     */
    public function playersTotal();
}
