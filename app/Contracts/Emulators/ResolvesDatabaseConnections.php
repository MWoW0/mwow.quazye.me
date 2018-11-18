<?php

namespace App\Contracts\Emulators;


interface ResolvesDatabaseConnections
{
    /**
     * Get the database connection resolver
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function connectionResolver();

    /**
     * Create a new database connection resolver
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function newConnectionResolver();

    /**
     * Get a characters database connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function characters();

    /**
     * Get a auth database connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function auth();

    /**
     * Get a world database connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function world();
}
