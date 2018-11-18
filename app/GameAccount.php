<?php

namespace App;

use App\Contracts\Emulator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function is_object;

class GameAccount extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'realm_id', 'emulator'
    ];

    public static function link(Account $account, User $toUser)
    {
        return new static([
            'account_id' => $account->id,
            'user_id' => $toUser->id
        ]);
    }

    public function through(Emulator $emulator)
    {
        return $this->fill([
            'emulator' => get_class($emulator)
        ]);
    }

    public function onRealm($realm)
    {
        return $this->fill([
            'realm_id' => is_object($realm) ? $realm->id : $realm
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function realm(): BelongsTo
    {
        return $this->belongsTo(Realm::class, 'realm_id');
    }
}
