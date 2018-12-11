<?php

namespace Tests;

use Illuminate\Support\Facades\DB;

trait TestsEmulatorDatabases
{
    public function createMangosAuthDatabases()
    {
        config(["database.connections.wotlk_realm" => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection('wotlk_realm')->unprepared(file_get_contents(__DIR__ . '/Fixtures/mangos_auth_sqlite3.sql'));

        config(["database.connections.cata_realm" => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection('cata_realm')->unprepared(file_get_contents(__DIR__ . '/Fixtures/mangos_auth_sqlite3.sql'));
    }
}
