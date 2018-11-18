<?php

namespace App\Emulators;

use App\Contracts\Emulator;
use App\Contracts\Emulators\ResolvesDatabaseConnections;
use function config;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

        $this->registerConfigurations();
        $this->addConnections();
    }

    /**
     * Add the current emulators database configurations
     *
     * @return void
     */
    public function registerConfigurations()
    {
        $connections = config('database.connections');

        $connections['auth'] = $this->emulator->config('db_auth');
        $connections['characters'] = $this->emulator->config('db_characters');
        $connections['world'] = $this->emulator->config('db_world');

        config(['database.connections' => $connections]);
    }

    /**
     * Extend the emulator database connections into the current connection resolver
     *
     * @return void
     */
    public function addConnections()
    {
        $this->connectionResolver()->extend('auth', function () {
            return $this->auth();
        });

        $this->connectionResolver()->extend('characters', function () {
            return $this->characters();
        });

        $this->connectionResolver()->extend('world', function () {
            return $this->world();
        });
    }

    /**
     * Get the database connection resolver
     *
     * @return \Illuminate\Database\DatabaseManager|\Illuminate\Database\ConnectionResolverInterface
     */
    public function connectionResolver()
    {
        return Model::getConnectionResolver();
    }

    /**
     * Create a new database connection resolver
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function newConnectionResolver()
    {
        return new ConnectionResolver([
            'auth' => $this->auth(),
            'characters' => $this->characters(),
            'world' => $this->world()
        ]);
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

    /**
     * Get a characters database connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function characters()
    {
        return DB::connection(
            $this->emulator->config('db_characters')
        );
    }

    /**
     * Get a world database connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function world()
    {
        return DB::connection(
            $this->emulator->config('db_world')
        );
    }
}
