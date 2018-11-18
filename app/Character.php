<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use EmulatorDatabases;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'characters';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'characters';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'guid';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public static function createForAccount($account, array $attributes = [])
    {
        return static::query()->create(array_merge($attributes, [
            'guid' => static::max('guid') + 1,
            'account' => $account->id
        ]));
    }

    public function reputation()
    {
        return $this->hasMany(CharacterReputation::class, 'guid');
    }

    public function realmCharacter()
    {
        return $this->belongsTo(RealmCharacter::class, 'account', 'acctid');
    }
}
