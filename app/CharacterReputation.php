<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;

class CharacterReputation extends Model
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
    protected $table = 'character_reputation';
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

    public function getFactionAttribute($value)
    {
        return Faction::name($value);
    }
}
