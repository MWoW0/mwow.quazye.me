<?php

namespace Tests;


use App\Emulators\Mangos;
use Illuminate\Support\Facades\DB;

trait TestsEmulatorDatabases
{
    /**
     * @var string
     */
    protected $mangosConnection;

    public function createSkyFireAuthDatabase()
    {
        config(['database.connections.skyfire_auth' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection('skyfire_auth')->unprepared(file_get_contents(__DIR__ . '/Fixtures/skyfire_auth_sqlite3.sql'));
    }

    public function createMangosAuthDatabase(string $expansion)
    {
        $this->mangosConnection = (new Mangos($expansion))->config('db_auth');

        config(["database.connections.{$this->mangosConnection}" => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection($this->mangosConnection)->unprepared(file_get_contents(__DIR__ . '/Fixtures/mangos_auth_sqlite3.sql'));
    }
}