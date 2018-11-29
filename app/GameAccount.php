<?php

namespace App;

use App\Facades\Emulator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameAccount extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'realm_id', 'emulator', 'expansion'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function account(): BelongsTo
    {
        $emulator = Emulator::driver($this->emulator);
        $emulator->expansion = $this->expansion;

        $account = Account::connectedTo($emulator);

        return $this->newBelongsTo(
            $account->newQuery(),
            $this,
            'account_id',
            $account->getKeyName(),
            null
        );
    }

    public function realm(): BelongsTo
    {
        $emulator = Emulator::driver($this->emulator);
        $emulator->expansion = $this->expansion;

        $realm = Realm::connectedTo($emulator);

        return $this->newBelongsTo(
            $realm->newQuery(),
            $this,
            'realm_id',
            $realm->getKeyName(),
            null
        );
    }
}
