<?php

namespace App;

use App\Events\GameAccountCreated;
use App\Events\GameAccountDeleted;
use App\Events\GameAccountUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function tap;

class GameAccount extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'realm_id', 'emulator', 'expansion'
    ];

    protected $dispatchesEvents = [
        'created' => GameAccountCreated::class,
        'updated' => GameAccountUpdated::class,
        'deleted' => GameAccountDeleted::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return Model|Account|null
     */
    public function resolveAccount()
    {
        if ($this->relationLoaded('account')) {
            return $this->getRelation('account');
        }

        $emulator = Emulator::make($this->emulator);
        $emulator->expansion = $this->expansion;

        return tap(Account::connectedTo($emulator)->findOrFail($this->account_id), function ($account) {
            $this->setRelation('account', $account);
        });
    }

    public function getAccountAttribute()
    {
        return $this->resolveAccount();
    }

    /**
     * @return Model|Realm|null
     */
    public function resolveRealm()
    {
        if ($this->relationLoaded('realm')) {
            return $this->getRelation('realm');
        }

        $emulator = Emulator::make($this->emulator);
        $emulator->expansion = $this->expansion;

        return tap(Realm::connectedTo($emulator)->findOrFail($this->realm_id), function ($realm) {
            $this->setRelation('realm', $realm);
        });
    }

    public function getRealmAttribute()
    {
        return $this->resolveRealm();
    }
}
