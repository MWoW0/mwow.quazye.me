<?php

namespace App\Contracts;

use App\Account;
use App\Emulators\EmulatorStatistics;
use App\User;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Database\Eloquent\Model;

interface Emulator
{
    /**
     * The WoW expansion name
     *
     * @return string|null
     */
    public function expansion(): ?string;

    /**
     * Get a value from the emulators configurations
     *
     * @param  string|null $key
     * @param  mixed $default
     * @return mixed
     */
    public function config(string $key = null, $default = null);

    /**
     * Name of the database connection
     *
     * @return string
     */
    public function connectionName(): string;

    /**
     * Connect the model to the emulators database
     *
     * @param Model $model
     * @return Model
     */
    public function connectModel(Model $model): Model;

    /**
     * Create a new game account for the emulator
     *
     * @param User $user
     * @param string $password
     * @return Account
     */
    public function createAccount(User $user, string $password): Account;

    /**
     * List the realms this emulator has
     *
     * @return DatabaseCollection
     */
    public function realms(): DatabaseCollection;

    /**
     * Get the emulator statistics
     *
     * @return EmulatorStatistics
     */
    public function statistics(): EmulatorStatistics;
}
