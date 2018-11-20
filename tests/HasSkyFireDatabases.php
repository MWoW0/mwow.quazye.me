<?php 

namespace Tests;

use Illuminate\Support\Facades\DB;

trait HasSkyFireDatabases 
{
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
}