<?php

namespace App\Emulators;

use App\Contracts\Emulator;
use App\Contracts\Emulators\ResolvesDatabaseConnections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function class_basename;
use function config;

class EmulatorDatabase implements ResolvesDatabaseConnections
{
    /**
     * The Emulator instance
     *
     * @var Emulator
     */
    protected $emulator;

    /**
     * EmulatorDatabaseConnectionResolver constructor.
     *
     * @param Emulator $emulator
     */
    public function __construct(Emulator $emulator)
    {
        $this->emulator = $emulator;
    }

    /**
     * Configure given model for establishing database connections to the current emulator.
     *
     * @param Model $model
     * @return Model
     */
    public function configureModel(Model $model)
    {
        $model::getConnectionResolver()->extend('auth', function () {
            return $this->auth();
        });

        $envPrefix = Str::upper($emulatorClass = class_basename($this->emulator));
        config(['database.connections.auth' => [
            'driver' => 'mysql',
            'host' => env("{$envPrefix}_DB_HOST", '127.0.0.1'),
            'port' => env("{$envPrefix}_DB_PORT", '3306'),
            'database' => env("{$envPrefix}_DB_DATABASE", $this->emulator->expansion() ? "{$this->emulator->expansion()}_realm" : Str::lower("{$emulatorClass}_auth")),
            'username' => env("{$envPrefix}_DB_USERNAME", env('DB_USERNAME')),
            'password' => env("{$envPrefix}_DB_PASSWORD", env('DB_PASSWORD')),
            'unix_socket' => env("{$envPrefix}_DB_SOCKET", ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]]);

        return $model;
    }

    /**
     * Get a auth database connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function auth()
    {
        return DB::connection(
            $this->emulator->config('db_auth')
        );
    }
}
