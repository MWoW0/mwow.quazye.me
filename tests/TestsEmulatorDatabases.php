<?php

namespace Tests;


use App\Emulators\Mangos;
use App\Emulators\SkyFire;
use Illuminate\Support\Facades\DB;

trait TestsEmulatorDatabases
{
    /**
     * @var string
     */
    protected $mangosConnection;

    /**
     * @var string
     */
    protected $skyfireConnection;

    public function createSkyFireAuthDatabase()
    {
        $this->skyfireConnection = (new SkyFire)->config('db_auth', 'skyfire');

        config(["database.connections.{$this->skyfireConnection}" => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection($this->skyfireConnection)->unprepared(file_get_contents(__DIR__ . '/Fixtures/skyfire_auth_sqlite3.sql'));
    }

    public function createMangosAuthDatabase(string $expansion = null)
    {
        $this->mangosConnection = (new Mangos($expansion))->config('db_auth', 'mangos');

        config(["database.connections.{$this->mangosConnection}" => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection($this->mangosConnection)->unprepared(file_get_contents(__DIR__ . '/Fixtures/mangos_auth_sqlite3.sql'));
    }
}