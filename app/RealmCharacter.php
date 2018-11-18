<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RealmCharacter extends Pivot
{
    use EmulatorDatabases;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'auth';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'realmcharacters';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'realmid';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function realm()
    {
        return $this->belongsTo(Realm::class, 'realmid');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'acctid');
    }
}
