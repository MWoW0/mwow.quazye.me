<?php

namespace Tests;

use Illuminate\Support\Facades\DB;

trait TestsEmulatorDatabases
{
    public function createMangosAuthDatabases()
    {
        config(["database.connections.realmd" => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection('realmd')->unprepared(file_get_contents(__DIR__ . '/Fixtures/mangos_auth_sqlite3.sql'));
    }
}
