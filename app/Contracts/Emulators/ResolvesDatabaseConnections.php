<?php

namespace App\Contracts\Emulators;


use Illuminate\Database\Eloquent\Model;

interface ResolvesDatabaseConnections
{
    /**
     * Configure given model for establishing database connections to the current emulator.
     *
     * @param Model $model
     * @return Model
     */
    public function configureModel(Model $model);

    /**
     * Get a auth database connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function auth();
}
