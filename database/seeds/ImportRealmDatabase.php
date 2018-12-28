<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportRealmDatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('database.connections.realmd.driver') === 'mysql') {
            $realmDatabase = config('database.connections.realmd.database');

            DB::unprepared("CREATE DATABASE IF NOT EXISTS`{$realmDatabase}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;");

            DB::connection('realmd')->unprepared(file_get_contents(__DIR__.'/mangosRealmdDatabase.sql'));
        }
    }
}
