<?php

namespace App\Emulators;

use App\Account;
use App\Contracts\Emulator;
use App\GameAccount;
use App\Hashing\Sha1Hasher;
use App\Realm;
use App\User;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Database\Eloquent\Model;
use function config;

class MangosCataclysm implements Emulator
{
    /**
     * The WoW expansion name
     *
     * @return string|null
     */
    public function expansion(): ?string
    {
        return 'cataclysm';
    }

    /**
     * Get a value from the emulators configurations
     *
     * @param  string|null $key
     * @param  mixed $default
     * @return mixed
     */
    public function config(string $key = null, $default = null)
    {
        if ($key) {
            return config("services.mangos.{$this->expansion()}.{$key}", $default);
        }

        return config("services.mangos.{$this->expansion()}", $default);
    }

    /**
     * Name of the database connection
     *
     * @return string
     */
    public function connectionName(): string
    {
        return $this->config('db_auth', "{$this->expansion()}_realm");
    }

    /**
     * Connect the model to the emulators database
     *
     * @param Model $model
     * @return Model
     */
    public function connectModel(Model $model): Model
    {
        $model->setConnection($this->connectionName());

        return $model;
    }

    /**
     * Create a new game account for the emulator
     *
     * @param User $user
     * @param string $password
     * @throws \Throwable
     * @return Account
     */
    public function createAccount(User $user, string $password): Account
    {
        $account = Account::connectedTo($this)->firstOrCreate([
            'username' => $user->account_name,
            'email' => $user->email,
            'sha_pass_hash' => (new Sha1Hasher)->make($password, ['account' => $user->account_name])
        ]);

        $this->connectModel(new Realm)
            ->newQuery()
            ->oldest('id')
            ->each(function (Realm $realm) use ($account, $user) {
                GameAccount::query()->firstOrCreate([
                    'user_id' => $user->getKey(),
                    'account_id' => $account->getKey(),
                    'realm_id' => $realm->getKey(),
                    'emulator' => static::class,
                    'expansion' => $this->expansion()
                ]);
            });

        return $account;
    }

    /**
     * List the realms this emulator has
     *
     * @return DatabaseCollection
     */
    public function realms(): DatabaseCollection
    {
        return Realm::connectedTo($this)->get();
    }

    /**
     * @return EmulatorStatistics
     */
    public function statistics(): EmulatorStatistics
    {
        return new EmulatorStatistics($this);
    }
}
